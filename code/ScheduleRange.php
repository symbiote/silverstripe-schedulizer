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
	);

	/**
	 * Detrimines the next valid time and date for this schedule to execute
	 * 
	 * @return object|null DateTime
	 */
	public function getNextDateTime() {
		$nextDateTime = $this->getScheduleDateTime();
		return $nextDateTime ? $nextDateTime->Format('Y-m-d H:i:s') : null;
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
			$nextDateTime = null;
		}
		
		return $nextDateTime;
	}
	
	public function getStartDateTime() {
		return new Datetime($this->StartDate .' '. $this->StartTime);
	}
	
	public function getEndDateTime() {
		return new Datetime($this->EndDate .' '. $this->EndTime);
	}
}
