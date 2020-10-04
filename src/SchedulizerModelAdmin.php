<?php

namespace Sunnysideup\Schedulizer;



use Sunnysideup\Schedulizer\ConfiguredSchedule;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\Admin\ModelAdmin;


/**
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class SchedulizerModelAdmin extends ModelAdmin {
	private static $menu_title = 'Schedulizer';
	private static $url_segment = 'schedulizer';

	private static $managed_models = array(
		ConfiguredSchedule::class
	);

	private static $allowed_actions = array(
		'testschedule'
	);
	
	public function testschedule($request) {
		$schedule = (int) $request->getVar('ID');
		$time = strtotime($request->getVar('date'));
		if ($schedule) {
			$schedule = ConfiguredSchedule::get()->byID($schedule);
		}
		if (!$time || !$schedule) {
			return 'Invalid date';
		}
		$date = date('Y-m-d H:i:s', $time);
		DBDatetime::set_mock_now($date);
		
		$dateTime = $schedule->getNextScheduledDateTime();
		if ($dateTime) {

/**
  * ### @@@@ START REPLACEMENT @@@@ ###
  * WHY: automated upgrade
  * OLD: ->format( (case sensitive)
  * NEW: ->format( (COMPLEX)
  * EXP: If this is a PHP Date format call then this needs to be changed to new Date formatting system. (see http://userguide.icu-project.org/formatparse/datetime)
  * ### @@@@ STOP REPLACEMENT @@@@ ###
  */
			return $dateTime->format('Y-m-d H:i:s');
		}
	}
}

