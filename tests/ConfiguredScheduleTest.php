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
	 * ConfiguredSchedule:
	 *   ConfigSched1:
	 *     Type: 1
	 *     DefaultInterval: 7200
	 *     DefaultStartTime: 010000
	 *     DefaultEndTime: 235959
	 * ScheduleRange:
	 *   sched1:
	 *     Interval: 3600
	 *     StartTime: 120000
	 *     EndTime: 170000
	 *     StartDate: 2015-10-01
	 *     EndDate: 2015-10-05
	 *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
	 * ScheduleRangeDay:
	 *   schedDay1:
	 *     Interval: 1800
	 *     StartTime: 120000
	 *     EndTime: 170000
	 *     StartDate: 2015-10-01
	 *     EndDate: 2015-10-31
	 *     ApplicableDays: Mon,Fri,Sat,Sun
	 *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
	 */

    public function testGetNextDateTimeBeforeSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//Before
		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
	}

    public function testGetNextDateTimeAfterSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//After
		SS_Datetime::set_mock_now('2015-10-06 11:50:00');
		$this->assertEquals('2015-10-09 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
	}

    public function testGetNextDateTimeDuringSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
	}

	public function testGetNextDateTimeDuringSRD() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-06 12:30:00');
		$this->assertEquals('2015-10-06 13:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
	}
}