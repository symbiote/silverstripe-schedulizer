<?php

namespace Sunnysideup\Schedulizer;

use DropdownField;

/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRangeDayType extends ScheduleRangeDay {

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', DropdownField::create('ApplicableDays', 'Schedule Day Type', array (
			'Mon,Tue,Wed,Thu,Fri'	=> 'Weekdays',
			'Sat,Sun'				=> 'Weekend'
		)));

		return $fields;
	}
}

