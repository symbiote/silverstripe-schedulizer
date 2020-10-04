<?php

namespace Sunnysideup\Schedulizer\Model\ScheduleRange;

use DateInterval;
use SilverStripe\Forms\CheckboxSetField;
use Sunnysideup\Schedulizer\Model\ScheduleRange;
/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRangeDay extends ScheduleRange
{

    private static $table_name = 'ScheduleRangeDay';

    public const WEEK_DAYS = [
        'Mon' => 'Monday',
        'Tue' => 'Tuesday',
        'Wed' => 'Wednesday',
        'Thu' => 'Thursday',
        'Fri' => 'Friday',
        'Sat' => 'Saturday',
        'Sun' => 'Sunday',
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            'Root.Main',
            CheckboxSetField::create(
                'ApplicableDays',
                'Schedule Days',
                self::WEEK_DAYS
            )
        );

        return $fields;
    }

    /**
     * Determines the next valid time and date for this schedule to execute
     *
     * @return DateTime|null
     */
    public function getNextDateTime() : ?DateTime
    {
        $nextRunDateTime = $this->getScheduleDateTime();

        if ($nextRunDateTime) {
            $i = 0; //In case getDays is corrupt exit after 7 tries.

            while (! in_array($nextRunDateTime->format('d'), $this->getDays(), true) && $i < 7) {
                $nextRunDateTime->add(new DateInterval('P1D'));
                //Reset the start time
                list($h, $m, $s) = explode(':', $this->StartTime);
                $nextRunDateTime->setTime($h, $m, $s);
                $i++;
            }
        }

        return $nextRunDateTime;
    }

    /**
     * Uses the ApplicableDays list to create a weeks worth of valid start/end dates
     */
    protected function getDays()
    {
        return explode(',', $this->ApplicableDays);
    }
}
