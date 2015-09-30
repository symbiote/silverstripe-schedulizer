<?php
/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
class ScheduleRangeDayTest extends SapphireTest {

	static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';
	/**
	 *   schedDay1:
	 *     Interval: 1800
	 *     StartTime: 050000
	 *     EndTime: 220000
	 *     StartDate: 2015-10-01
	 *     EndDate: 2015-10-31
	 *     ApplicableDays: Mon,Fri,Sat,Sun
	 *     ConfiguredSchedule: =>ConfiguredSchedule.ConfigSched1
	 *
	 * Oct 1st = Thrusday (off day)
	 * Oct 2nd = Friday (on day)
	 * Oct 3rd = Saturday (on day)
	 * Oct 4th = Sunday (on day)
	 * Oct 5th = Monday (on day)
	 * Oct 6th = Tuesday (off day)
	 */

    public function testGetNextDateTimeOnDay() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//Before
		SS_Datetime::set_mock_now('2015-10-02 04:50:00');
		$this->assertEquals('2015-10-02 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
	}

    public function testGetNextDateTimeOnDayOutOfTimeRange() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//After
		SS_Datetime::set_mock_now('2015-10-02 22:50:00');
		$this->assertEquals('2015-10-03 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
	}

    public function testGetNextDateTimeOffDay() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//After
		SS_Datetime::set_mock_now('2015-10-06 11:50:00');
		$this->assertEquals('2015-10-09 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
	}

	public function testGetNextDateTimeOffDayOutOfTimeRange() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//After
		SS_Datetime::set_mock_now('2015-10-06 22:50:00');
		$this->assertEquals('2015-10-09 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
	}

    public function testGetNextDateTimeDuring() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//During
		SS_Datetime::set_mock_now('2015-10-03 12:30:00');
		$this->assertEquals('2015-10-03 13:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
	}
}