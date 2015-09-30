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
		$now = new DateTimeImmutable(SS_Datetime::now());
		$return = null;
		$tomorrow = $now->add(new DateInterval('P1D'))->setTime(23, 59, 59);
		//filter SpecificRanges by end date
		$currentRanges = $this->ScheduleRanges()->filter(array(
			'EndDate:GreaterThan' => $now->format('Y-m-d H:i:s')
		));
		//loop each type and find a 'winner'
		$ranges = array();

		foreach ($currentRanges as $specficRange) {
			$dateTime = $specficRange->getNextDateTime();
			if (isset($ranges[$specficRange->ClassName]) && $ranges[$specficRange->ClassName] > $dateTime) {
				$ranges[$specficRange->ClassName] = $dateTime;
			} elseif (!isset($ranges[$specficRange->ClassName])) {
				$ranges[$specficRange->ClassName] = $dateTime;
			}
		}

		if(!empty($ranges['ScheduleRange']) && $ranges['ScheduleRange'] < $tomorrow) {

			$return = $ranges['ScheduleRange'];

		} elseif (!empty($ranges['ScheduleRangeDay']) && $ranges['ScheduleRangeDay'] < $tomorrow) {

			$return = $ranges['ScheduleRangeDay'];

		} elseif (empty($ranges['ScheduleRange']) || $ranges['ScheduleRange'] > $ranges['ScheduleRangeDay']) {

			$return = $ranges['ScheduleRangeDay'];

		} elseif(!empty($ranges['ScheduleRange'])) {

			$return = $ranges['ScheduleRange'];
		}

		return $return;
	}
}
