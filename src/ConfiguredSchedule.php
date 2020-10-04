<?php
/**
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ConfiguredSchedule  extends DataObject {


/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * OLD: private static $db (case sensitive)
  * NEW: 
    private static $table_name = '[SEARCH_REPLACE_CLASS_NAME_GOES_HERE]';

    private static $db (COMPLEX)
  * EXP: Check that is class indeed extends DataObject and that it is not a data-extension!
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
	
    private static $table_name = 'ConfiguredSchedule';

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
			Requirements::javascript('sunnysideup/silverstripe-schedulizer: schedulizer/js/schedulizer-admin.js');

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->RenderWith( (ignore case)
  * NEW: ->RenderWith( (COMPLEX)
  * EXP: Check that the template location is still valid!
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			$fields->addFieldToTab('Root.Main', LiteralField::create('testingbits', $this->RenderWith('TestScheduleField')));
		}

		return $fields;
	}

	public function getNextScheduledDateTime() {
		$now = new DateTime(SS_Datetime::now());
		$return = NULL;
		
		//filter SpecificRanges by end date
		$currentRanges = $this->ScheduleRanges()->filter(array(

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: >format('Y-m-d') (case sensitive)
  * NEW: ->format('Y-MM-d') (COMPLEX)
  * EXP: check usage of new date/time system https://www.php.net/manual/en/datetime.format.php vs http://userguide.icu-project.org/formatparse/datetime
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			'EndDate:GreaterThanOrEqual' => $now-->format('Y-MM-d')
		));
		//loop each type and find a 'winner'
		$ranges = [];

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
		$candidates = [];
		foreach ($ranges as $key => $time) {
			// take the day of the given time

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: >format('Y-m-d') (case sensitive)
  * NEW: ->format('Y-MM-d') (COMPLEX)
  * EXP: check usage of new date/time system https://www.php.net/manual/en/datetime.format.php vs http://userguide.icu-project.org/formatparse/datetime
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			$timeDay = $time-->format('Y-MM-d');
			
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

