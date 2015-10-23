<?php
/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ScheduleRangeDefault extends ScheduleRangeDay {

	public function onBeforeWrite() {
		parent::onBeforeWrite();
		$this->ApplicableDays = 'Mon,Tue,Wed,Thu,Fri,Sat,Sun';
	}
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('ApplicableDays');
		return $fields;
	}
}
