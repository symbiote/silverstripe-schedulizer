<?php

use SilverStripe\Dev\SapphireTest;
use SilverStripe\ORM\FieldType\DBDatetime;
use Sunnysideup\Schedulizer\ScheduleRange;

/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRangeTest extends SapphireTest
{
    public static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';

    /*
     * ScheduleRange:
     *   sched1:
     *     Interval: 3600
     *     StartTime: 120000
     *     EndTime: 170000
     *     StartDate: 2015-10-01
     *     EndDate: 2015-10-05
     *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
     */

    public function testGetNextDateTimeBefore()
    {
        $sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

        //Before
        DBDatetime::set_mock_now('2015-10-01 11:50:00');

        $this->assertSame('2015-10-01 12:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
    }

    public function testGetNextDateTimeAfter()
    {
        $sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

        //After
        DBDatetime::set_mock_now('2015-10-06 11:50:00');
        $result = $sched->getNextDateTime();
        $this->assertSame(null, $result);
    }

    public function testGetNextDateTimeDuring()
    {
        $sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

        //During
        DBDatetime::set_mock_now('2015-10-02 12:30:00');
        $this->assertSame('2015-10-02 13:30:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
    }

    public function testGetNextDateTimeDuringAfterTimeRange()
    {
        $sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

        //During
        DBDatetime::set_mock_now('2015-10-02 17:30:00');
        $this->assertSame('2015-10-03 12:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
    }
}
