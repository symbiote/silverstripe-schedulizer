<?php
/**
 * Description of ConfiguredSchedule
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ConfiguredSchedule  extends DataObject {

	private static $db = array (
		'Title'				=> 'VarChar',
	);

	private static $has_many = array (
		'ScheduleRanges'	=> 'ScheduleRange'
	);

	/**
	 * @testdox only used for returning test data
	 *
	 * @var string
	 */
	protected $currentSchedule = null;

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		if ($this->ID) {
			Requirements::javascript('schedulizer/js/schedulizer-admin.js');
			$fields->addFieldToTab('Root.Main', LiteralField::create('testingbits', $this->renderWith('TestScheduleField')));
		}

		return $fields;
	}

	public function getNextScheduledDateTime() {
		$now = new DateTimeImmutable(SS_Datetime::now());
		$return = NULL;
		
		//filter SpecificRanges by end date
		$currentRanges = $this->ScheduleRanges()->filter(array(
			'EndDate:GreaterThanOrEqual' => $now->format('Y-m-d')
		));
		//loop each type and find a 'winner'
		$ranges = array();

		foreach ($currentRanges as $specficRange) {
			$dateTime = $specficRange->getNextDateTime();
			if (!$dateTime) {
				continue;
			}
			if (isset($ranges[$specficRange->ClassName]) && $ranges[$specficRange->ClassName] > $dateTime) {
				$ranges[$specficRange->ClassName] = $dateTime;
			} elseif (!isset($ranges[$specficRange->ClassName])) {
				$ranges[$specficRange->ClassName] = $dateTime;
			}
		}

		if(empty($ranges)) {
			$this->currentSchedule = 'None';
			return null;
		}

		

		// prune the collected list back to those that fall on the _next available day_
		asort($ranges);
		$earliestDay = '';
		$candidates = array();
		foreach ($ranges as $key => $time) {
			// take the day of the given time
			$timeDay = $time->format('Y-m-d');
			
			// no 'earliest' just yet
			if (!$earliestDay) {
				$earliestDay = $timeDay;
				$candidates[$key] = $time;
				continue;
			}
			
			// if the same, add to candidates
			if ($earliestDay == $timeDay && !isset($candidates[$key])) {
				$candidates[$key] = $time;
			}
		}
		
		// now, let's check the day based precedence
		$scheduleRangesOrder = $this->config()->get('schedule_range_precedence');
		foreach($scheduleRangesOrder as $schedulerange) {
			$comparisonRange = isset($candidates[$schedulerange]) ? $candidates[$schedulerange] : null;
			if($comparisonRange) {
				$return = $comparisonRange;
				$this->currentSchedule = $schedulerange;
				break;
			}
		}

		// otherwise, we just take the next available time regardless of source
		if($return === NULL) {
			if(!empty($candidates)) {
				$return = current($candidates);
				reset($candidates);
				$this->currentSchedule = key($candidates);
			}
		}

		return $return;
	}

	public function getCMSValidator() {
        return new RequiredFields(array(
            'Title',
        ));
    }

	/**
	 * @testdox
	 * 
	 * @return string
	 */
	public function getCurrentSchedule() {
		return $this->currentSchedule;
	}
}
