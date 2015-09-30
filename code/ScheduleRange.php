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
		//Seconds between scheduled times
		'Interval'			=> 'Int',
		'StartTime'			=> 'Time',
		'EndTime'			=> 'Time',
		'StartDate'			=> 'Date',
		'EndDate'			=> 'Date',
		//Days this schedule is valid (e.g 'Monday,Tuesday,Wednesday,Thrusday,Friday')
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


	/**
	 * Detrimines the next valid time and date for this schedule to execute
	 *
	 * @return object|null DateTime
	 */
	public function getNextDateTime() {

		return $this->getScheduleDateTime();
	}

	protected function getScheduleDateTime() {

		$now = new Datetime(SS_Datetime::now()->Format(DateTime::ATOM));
		// Presume where checking at a point before the StartDate
		$nextDateTime = $this->getStartDateTime();

		if($now > $this->getStartDateTime()) {
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
		$scheduleDay->add(new DateInterval("P{$this->day}D"));
		return $scheduleDay->format('Y-m-d');
	}

	protected function goToNextDay() {
		$this->day++;
	}
}
