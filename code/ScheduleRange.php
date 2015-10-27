<?php
/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ScheduleRange extends DataObject {

	private static $db = array (
		'Title'				=> 'VarChar',
		//Seconds between scheduled times
		'Interval'			=> 'Int',
		'StartTime'			=> 'Time',
		'EndTime'			=> 'Time',
		'StartDate'			=> 'Date',
		'EndDate'			=> 'Date',
		//Days this schedule is valid (e.g 'Monday,Tuesday,Wednesday,Thrusday,Friday,Weekend,Weekday')
		'ApplicableDays'	=> 'VarChar'
	);

	private static $has_one = array(
		'ConfiguredSchedule' => 'ConfiguredSchedule'
	);

	/**
	 * The day we're at in a Range when looking for the next valid.
	 * @var Int
	 */
	protected $day = 0;

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->removeByName('ConfiguredScheduleID');

		$interval = $fields->dataFieldByName('Interval')
			->setDescription('Number of seconds between each run. e.g 3600 is 1 hour');
		$fields->replaceField('Interval',
			$interval
		);

		$dt = new DateTime();
		
		$fields->replaceField('StartDate',
			DateField::create('StartDate')
				->setConfig('dateformat', 'dd/MM/yyyy')
				->setConfig('showcalendar', true)
				->setDescription(
					'DD/MM/YYYY e.g. ' . $dt->format('d/m/y')
				)
		);

		$fields->replaceField('EndDate',
			DateField::create('EndDate')
				->setConfig('dateformat', 'dd/MM/yyyy')
				->setConfig('showcalendar', true)
				->setDescription(
					'DD/MM/YYYY e.g. ' . $dt->format('d/m/y')
				)
		);

		if ($this->ID == null) {
			foreach ($fields->dataFields() as $field) {
				//delete all included fields
				$fields->removeByName($field->Name);
			}
			
			$rangeTypes = ClassInfo::subclassesFor('ScheduleRange');

			$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
			$fields->addFieldToTab('Root.Main', DropdownField::create('ClassName', 'Range Type', $rangeTypes));

		} else {
			$fields->addFieldToTab('Root.Main', ReadonlyField::create('ClassName', 'Type'));
		}
		
		if ($this->ClassName == __CLASS__) {
			$fields->removeByName('ApplicableDays');
		}

		return $fields;
	}

	public function getCMSValidator() {
		if ($this->ID) {
			return new RequiredFields(array(
				'Title',
				'Interval',
				'StartTime',
				'EndTime',
				'StartDate',
				'EndDate'
			));
		}
    }

	/**
	 * Detrimines the next valid time and date for this schedule to execute
	 *
	 * @return object|null DateTime
	 */
	public function getNextDateTime() {
		$this->day = 0;
		return $this->getScheduleDateTime();
	}

	protected function getScheduleDateTime() {
		$now = new Datetime(SS_Datetime::now()->Format(DateTime::ATOM));
		// Presume where checking at a point before the StartDate
		$nextDateTime = $this->getStartDateTime();
		
		if($now >= $this->getStartDateTime()) {
			//Inside the ScheduleRange so set nextDateTime to now + interval
			$nextDateTime = $now->add(new DateInterval('PT' . $this->Interval . 'S'));
		}

		if ($nextDateTime > $this->getEndDateTime()) {
			//Now + interval falls outside the Schedule range
			if($nextDateTime > $this->getLastScheduleTime()) {
				$nextDateTime = null;
			} else {
				$this->goToNextDay();
				$nextDateTime = $this->getScheduleDateTime();
			}
		}

		return $nextDateTime;
	}

	public function getStartDateTime() {
		return new Datetime($this->getScheduleDay() .' '. $this->StartTime);
	}

	/**
	 * The end time for the start/end block
	 * @return \Datetime
	 */
	public function getEndDateTime() {
		return new Datetime($this->getScheduleDay() .' '. $this->EndTime);
	}

	/**
	 * The end time for the start/end block
	 * @return \Datetime
	 */
	public function getLastScheduleTime() {
		return new Datetime($this->EndDate .' '. $this->EndTime);
	}

	protected function getScheduleDay() {
		$scheduleDay = new Datetime($this->StartDate .' '. $this->StartTime);
		$now = new Datetime(SS_Datetime::now()->Format(DateTime::ATOM));
		
		// make sure that the 'day' we start looking from is close to 'now' so our
		// loops don't work through days that don't matter
		if (!$this->day && $now > $scheduleDay) {
			$diff = $now->diff($scheduleDay)->format("%r%a");
			$this->day = abs($diff);
		}
		
		$scheduleDay->add(new DateInterval("P{$this->day}D"));
		return $scheduleDay->format('Y-m-d');
	}

	protected function goToNextDay() {
		$this->day++;
	}
}
