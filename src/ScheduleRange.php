<?php

namespace Sunnysideup\Schedulizer;

use DataObject;
use DateTime;
use DateField;
use ClassInfo;
use TextField;
use DropdownField;
use ReadonlyField;
use RequiredFields;
use Datetime;
use SS_Datetime;
use DateInterval;

/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRange extends DataObject {


/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * OLD: private static $db (case sensitive)
  * NEW: 
    private static $table_name = '[SEARCH_REPLACE_CLASS_NAME_GOES_HERE]';

    private static $db (COMPLEX)
  * EXP: Check that is class indeed extends DataObject and that it is not a data-extension!
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
	
    private static $table_name = 'ScheduleRange';

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

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
					'DD/MM/YYYY e.g. ' . $dt->format('d/m/y')
				)
		);

		$fields->replaceField('EndDate',
			DateField::create('EndDate')
				->setConfig('dateformat', 'dd/MM/yyyy')
				->setConfig('showcalendar', true)
				->setDescription(

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
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
		

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: $this->ClassName (case sensitive)
  * NEW: $this->ClassName (COMPLEX)
  * EXP: Check if the class name can still be used as such
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
		if ($this->ClassName == __CLASS__) {
			$fields->removeByName('ApplicableDays');
		}

		return $fields;
	}

	public function getCMSValidator() {
        $fields = array('Title');
		if ($this->ID) {
			$fields = array(
				'Title',
				'Interval',
				'StartTime',
				'EndTime',
				'StartDate',
				'EndDate'
			);
		} 
        return new RequiredFields($fields);
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
		// get a start time for 'today'
		$nextDateTime = $this->getStartDateTime();
		
		if($now >= $nextDateTime) {
			//Inside the ScheduleRange so set nextDateTime to now + interval
			$nextDateTime = $now->add(new DateInterval('PT' . $this->Interval . 'S'));
		}

        // and an end-time for 'today'
        $todayEndTime = $this->getEndDateTime();

        $lastEndTime = $this->getLastScheduleTime();

		if ($nextDateTime > $todayEndTime) {
			//Now + interval falls outside the Schedule range
			if($nextDateTime > $lastEndTime) {
				$nextDateTime = null;
			} else {
				$this->goToNextDay();
				$nextDateTime = $this->getScheduleDateTime();
			}
		}

        // lastly, compare the very last date time.
        if($nextDateTime > $lastEndTime) {
            $nextDateTime = null;
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

    public function __accessForgetScheduleDay() {

    }

	protected function getScheduleDay() {
		$scheduleDay = new Datetime($this->StartDate .' '. $this->StartTime);

        // we use $this->StartTime, because if we leave it as 'now' time, we may actually be closer to
        // the _next_ day, and the diff logic further on will instead return +1 day more than we expect. 
		$now = new Datetime(SS_Datetime::now()->Format('Y-m-d ' . $this->StartTime));
		
		// make sure that the 'day' we start looking from is close to 'now' so our
		// loops don't work through days that don't matter
		if (!$this->day && $now > $scheduleDay) {

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			$diff = $now->diff($scheduleDay)->format("%r%a");
			$this->day = abs($diff);
		}
		
		$scheduleDay->add(new DateInterval("P{$this->day}D"));

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: >format('Y-m-d') (case sensitive)
  * NEW: ->format('Y-MM-d') (COMPLEX)
  * EXP: check usage of new date/time system https://www.php.net/manual/en/datetime.format.php vs http://userguide.icu-project.org/formatparse/datetime
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
		return $scheduleDay-->format('Y-MM-d');
	}

	protected function goToNextDay() {
		$this->day++;
	}
}

