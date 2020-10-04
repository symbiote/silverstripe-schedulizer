<?php

namespace Sunnysideup\Schedulizer;

use CheckboxSetField;
use DateInterval;

/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRangeDay extends ScheduleRange {

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', CheckboxSetField::create('ApplicableDays', 'Schedule Days', array (
			'Mon'	=> 'Monday',
			'Tue'	=> 'Tuesday',
			'Wed'	=> 'Wednesday',
			'Thu'	=> 'Thursday',
			'Fri'	=> 'Friday',
			'Sat'	=> 'Saturday',
			'Sun'	=> 'Sunday'
		)));

		return $fields;
	}

	/**
	 * Detrimines the next valid time and date for this schedule to execute
	 *
	 * @return object DateTime
	 */
	public function getNextDateTime() {
		$nextRunDateTime = $this->getScheduleDateTime();

		if($nextRunDateTime) {
			$i = 0; //In case getDays is corrupt exit after 7 tries.

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			while (!in_array($nextRunDateTime->format('D'), $this->getDays()) && $i < 7) {
				$nextRunDateTime->add(new DateInterval('P1D'));
				//Reset the start time
				list($h, $m, $s) = explode(':', $this->StartTime);
				$nextRunDateTime->setTime($h, $m, $s);
				$i++;
			}
		}

		return $nextRunDateTime;
	}

	/**
	 * Uses the ApplicableDays list to create a weeks worth of valid start/end dates
	 */
	protected function getDays() {

		return explode(',', $this->ApplicableDays);
	}
}

