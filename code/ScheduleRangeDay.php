<?php
/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ScheduleRangeDay extends ScheduleRange {
	
	private static $db = array (
		//Days this schedule is valid (e.g 'Monday,Tuesday,Wednesday,Thrusday,Friday')
		'ApplicableDays'	=> 'VarChar'
	);

	/**
	 * Detrimines the next valid time and date for this schedule to execute
	 * 
	 * @return object DateTime
	 */
	public function getNextDateTime() {
		$nextRunDateTime = $this->getScheduleDateTime();
		
		if($nextRunDateTime) {
			$i = 0; //In case getDays is corrupt exit after 7 tries.
			while (!in_array($nextRunDateTime->format('D'), $this->getDays()) && $i < 7) {
				$nextRunDateTime->add(new DateInterval('P1D'));
				$i++;
			}
		}
		
		return $nextRunDateTime ? $nextRunDateTime->Format('Y-m-d H:i:s') : null;
	}
	
	/**
	 * Uses the ApplicableDays list to create a weeks worth of valid start/end dates
	 */
	protected function getDays() {
		
		return explode(',', $this->ApplicableDays);
	}
}
