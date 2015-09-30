<?php
/**
 * Description of ConfiguredSchedule
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ConfiguredSchedule  extends DataObject {

	private static $db = array (
		'Type'				=> 'Int',
		'DefaultInterval'	=> 'Int',
		'DefaultStartTime'	=> 'Time',
		'DefaultEndTime'	=> 'Time'
	);

	private static $has_many = array (
		'ScheduleRanges'	=> 'ScheduleRange'
	);

	public function getNextScheduledDateTime() {
		$now = new DateTime();
		//filter SpecificRanges by end date
		$currentRanges = $this->ScheduleRanges()->filter(array(
			'EndDate:GreaterThan' => $now->format('Y-m-d H:i:s')
		));
		//loop each type and find a 'winner'
		$winners = array();

		foreach ($currentRanges as $specficRange) {
			$dateTime = $specficRange->getNextDateTime();
			if (isset($winners[$specficRange->ClassName]) && $winners[$specficRange->ClassName] < $dateTime) {
				$winners[$specficRange->ClassName] = $dateTime;
			} else {
				$winners[$specficRange->ClassName] = $dateTime;
			}
		}

		if ($winners['ScheduleRange'] > $winners['ScheduleRangeDay']) {
			return $winners['ScheduleRangeDay'];
		}

		return $winners['ScheduleRange'];
	}
}
