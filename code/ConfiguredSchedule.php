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

	protected $currentSchedule = null;

	public function getNextScheduledDateTime() {
		$now = new DateTimeImmutable(SS_Datetime::now());
		$return = NULL;
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

		if(empty($ranges)) {
			$this->currentSchedule = 'DefaultSchedule';
			return $now->add(new DateInterval('PT' . $this->DefaultInterval . 'S'));
		}

		$scheduleRangesOrder = $this->config()->get('ScheduleRanges');

		foreach($scheduleRangesOrder as $schedulerange) {
			if(isset($ranges[$schedulerange])) {
				if ($ranges[$schedulerange] < $tomorrow) {
					$return = $ranges[$schedulerange];
					$this->currentSchedule = $schedulerange;
					break;
				}
			}
		}

		if($return === NULL) {
			asort($ranges);
			if(!empty($ranges)) {
				$return = current($ranges);
				reset($ranges);
				$this->currentSchedule = key($ranges);
			}
		}

		return $return;
	}

	public function getCurrentSchedule() {
		return $this->currentSchedule;
	}
}
