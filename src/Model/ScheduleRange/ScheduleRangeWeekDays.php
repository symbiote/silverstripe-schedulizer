<?php

namespace Sunnysideup\Schedulizer\Model\ScheduleRange;
use Sunnysideup\Schedulizer\Model\ScheduleRange;


class ScheduleRangeWeekDays extends ScheduleRangeDay
{

    private static $table_name = 'ScheduleRangeWeekDays';

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->ApplicableDays = 'Mon,Tue,Wed,Thu,Fri';
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ApplicableDays');
        return $fields;
    }
}
