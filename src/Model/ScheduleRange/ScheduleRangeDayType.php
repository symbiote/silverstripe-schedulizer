<?php

namespace Sunnysideup\Schedulizer\Model\ScheduleRange;

use SilverStripe\Forms\DropdownField;
use Sunnysideup\Schedulizer\Model\ScheduleRange;
/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRangeDayType extends ScheduleRangeDay
{

    private static $table_name = 'ScheduleRangeDayType';

    public const WEEK_WEEKEND_DAYS = [
        'Mon,Tue,Wed,Thu,Fri' => 'Weekdays',
        'Sat,Sun' => 'Weekend',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main',
            DropdownField::create(
                'ApplicableDays',
                'Schedule Day Type',
                self::WEEK_WEEKEND_DAYS
            )
        );

        return $fields;
    }
}
