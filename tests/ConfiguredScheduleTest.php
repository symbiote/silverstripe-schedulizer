<?php
/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
class ConfiguredScheduleTest extends SapphireTest {

	static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';

	/*
	 * ScheduleRange:
	 *   sched1:
	 *     Interval: 3600
	 *     StartTime: 120000
	 *     EndTime: 235959
	 *     StartDate: 2015-10-01
	 *     EndDate: 2015-10-02
	 *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
	 */

    public function testGetNextDateTimeBefore() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//Before
		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextScheduledDateTime());
	}

    public function testGetNextDateTimeAfter() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//After
		SS_Datetime::set_mock_now('2015-10-06 11:50:00');
		$this->assertEquals(null, $sched->getNextScheduledDateTime());
	}

    public function testGetNextDateTimeDuring() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextScheduledDateTime());
	}
}