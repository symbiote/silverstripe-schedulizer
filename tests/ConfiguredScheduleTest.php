<?php

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\FieldType\DBDatetime;
use Sunnysideup\Schedulizer\ConfiguredSchedule;
use Sunnysideup\Schedulizer\ScheduleRange;
use Sunnysideup\Schedulizer\ScheduleRangeDay;
use Sunnysideup\Schedulizer\ScheduleRangeDefault;

/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ConfiguredScheduleTest extends SapphireTest
{
    public static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';

    /*
     * ConfiguredSchedule:
     *   ConfigSched1:
     *     Type: 1
     *     DefaultInterval: 7200
     *     DefaultStartTime: 000000
     *     DefaultEndTime: 235959
     * ScheduleRange:
     *   sched1:
     *     Interval: 3600
     *     StartTime: 120000
     *     EndTime: 170000
     *     StartDate: 2015-10-01
     *     EndDate: 2015-10-05
     *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
     *   sched2:
     *     Interval: 3600
     *     StartTime: 120000
     *     EndTime: 170000
     *     StartDate: 2015-10-08
     *     EndDate: 2015-10-13
     *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
     * ScheduleRangeDay:
     *   schedDay1:
     *     Interval: 1800
     *     StartTime: 050000
     *     EndTime: 220000
     *     StartDate: 2015-10-01
     *     EndDate: 2015-10-31
     *     ApplicableDays: Mon,Fri,Sat,Sun
     *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
     */

    public function testGetNextDateTimeBeforeSR()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //Before
        DBDatetime::set_mock_now('2015-10-01 11:50:00');
        $this->assertSame('2015-10-01 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRange::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeAfterSR()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched3');
        // After
        DBDatetime::set_mock_now('2015-10-06 12:00:00');
        $this->assertSame('2015-10-08 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRange::class, $sched->getCurrentSchedule());

        DBDatetime::set_mock_now('2015-10-13 18:00:00');
        $this->assertSame('2015-10-16 05:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRangeDay::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeDuringSR()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //During
        DBDatetime::set_mock_now('2015-10-02 12:30:00');
        $this->assertSame('2015-10-02 13:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRange::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeAfterSRD()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //During
        DBDatetime::set_mock_now('2015-11-01 12:00:00');
        $this->assertSame('2015-11-01 14:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRangeDefault::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeBeforeSR2()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //Before
        DBDatetime::set_mock_now('2015-10-02 01:30:00');
        $this->assertSame('2015-10-02 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRange::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeAfterSR2()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //After
        DBDatetime::set_mock_now('2015-10-05 17:30:00');
        $this->assertSame('2015-10-05 18:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRangeDay::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeDuringSR2()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //During
        DBDatetime::set_mock_now('2015-10-03 14:30:00');
        $this->assertSame('2015-10-03 15:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRange::class, $sched->getCurrentSchedule());
    }

    public function testGetNextDateTimeDuringSRButOvertime()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

        //During
        DBDatetime::set_mock_now('2015-10-03 16:45:00');
        // triggers the day based rule, as Oct-03 is a saturday, meaning its range goes 5am -> 22pm, every 30 minutes
        $this->assertSame('2015-10-03 17:15:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
        $this->assertSame(ScheduleRangeDay::class, $sched->getCurrentSchedule());
    }

    public function testPrecedence()
    {
        $sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched2');

        $times = [];

        DBDatetime::set_mock_now('2015-10-22 23:55:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        DBDatetime::set_mock_now('2015-10-23 00:00:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        DBDatetime::set_mock_now('2015-10-23 05:00:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        DBDatetime::set_mock_now('2015-10-23 23:55:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        DBDatetime::set_mock_now('2015-10-24 04:00:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        DBDatetime::set_mock_now('2015-10-24 23:55:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        // sunday evening
        DBDatetime::set_mock_now('2015-10-25 23:55:00');
        $times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

        $this->assertSame('2015-10-23 06:00:00', $times[0]);
        $this->assertSame('2015-10-23 06:00:00', $times[1]);
        $this->assertSame('2015-10-23 06:00:00', $times[2]);
        $this->assertSame('2015-10-24 05:00:00', $times[3]);
        $this->assertSame('2015-10-24 05:00:00', $times[4]);
        $this->assertSame('2015-10-25 05:00:00', $times[5]);
        $this->assertSame('2015-10-26 06:00:00', $times[6]);
    }
}
