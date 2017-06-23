<?php
/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ConfiguredScheduleTest extends SapphireTest {

	static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';

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

    public function testGetNextDateTimeBeforeSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//Before
		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
	}

    public function testGetNextDateTimeAfterSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched3');
		// After
		SS_Datetime::set_mock_now('2015-10-06 12:00:00');
		$this->assertEquals('2015-10-08 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
		
		SS_Datetime::set_mock_now('2015-10-13 18:00:00');
		$this->assertEquals('2015-10-16 05:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
	}

    public function testGetNextDateTimeDuringSR() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
	}

	public function testGetNextDateTimeAfterSRD() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
		
		//During
		SS_Datetime::set_mock_now('2015-11-01 12:00:00');
		$this->assertEquals('2015-11-01 14:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRangeDefault', $sched->getCurrentSchedule());
	}


    public function testGetNextDateTimeBeforeSR2() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//Before
		SS_Datetime::set_mock_now('2015-10-02 01:30:00');
		$this->assertEquals('2015-10-02 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
	}

    public function testGetNextDateTimeAfterSR2() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//After
		SS_Datetime::set_mock_now('2015-10-05 17:30:00');
		$this->assertEquals('2015-10-05 18:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
	}

    public function testGetNextDateTimeDuringSR2() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-03 14:30:00');
		$this->assertEquals('2015-10-03 15:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
	}

	public function testGetNextDateTimeDuringSRButOvertime() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');

		//During
		SS_Datetime::set_mock_now('2015-10-03 16:45:00');
		// triggers the day based rule, as Oct-03 is a saturday, meaning its range goes 5am -> 22pm, every 30 minutes
		$this->assertEquals('2015-10-03 17:15:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
	}
	
	public function testPrecedence() {
		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched2');
		
		$times = array();
		
		SS_Datetime::set_mock_now('2015-10-22 23:55:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		SS_Datetime::set_mock_now('2015-10-23 00:00:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		SS_Datetime::set_mock_now('2015-10-23 05:00:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		SS_Datetime::set_mock_now('2015-10-23 23:55:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		SS_Datetime::set_mock_now('2015-10-24 04:00:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		SS_Datetime::set_mock_now('2015-10-24 23:55:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		// sunday evening
		SS_Datetime::set_mock_now('2015-10-25 23:55:00');
		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');
		
		$this->assertEquals('2015-10-23 06:00:00', $times[0]);
		$this->assertEquals('2015-10-23 06:00:00', $times[1]);
		$this->assertEquals('2015-10-23 06:00:00', $times[2]);
		$this->assertEquals('2015-10-24 05:00:00', $times[3]);
		$this->assertEquals('2015-10-24 05:00:00', $times[4]);
		$this->assertEquals('2015-10-25 05:00:00', $times[5]);
		$this->assertEquals('2015-10-26 06:00:00', $times[6]);
	}
}