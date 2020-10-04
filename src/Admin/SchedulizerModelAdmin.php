<?php

namespace Sunnysideup\Schedulizer\Admin;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\ORM\FieldType\DBDatetime;
use Sunnysideup\Schedulizer\Model\ConfiguredSchedule;

/**
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class SchedulizerModelAdmin extends ModelAdmin
{
    private static $menu_title = 'Schedulizer';

    private static $url_segment = 'schedulizer';

    private static $managed_models = [
        ConfiguredSchedule::class,
    ];

    private static $allowed_actions = [
        'testschedule',
    ];

    public function testschedule($request)
    {
        $schedule = (int) $request->getVar('ID');
        $time = strtotime($request->getVar('date'));
        if ($schedule) {
            $schedule = ConfiguredSchedule::get()->byID($schedule);
        }
        if (! $time || ! $schedule) {
            return 'Invalid date';
        }
        // $date = date('Y-m-d H:i:s', $time);
        // DBDatetime::set_mock_now($date);

        $dateTime = $schedule->getNextScheduledDateTime();
        if ($dateTime) {
            return $dateTime->format('Y-m-d H:i:s');
        }
    }
}
