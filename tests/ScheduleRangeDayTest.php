<?php
/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ScheduleRangeDayTest extends SapphireTest {
	
	static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';
	/**
	 *   schedDay1:
	 *     Interval: 3600
	 *     StartTime: 120000
	 *     EndTime: 235959
	 *     StartDate: 2015-10-01
	 *     EndDate: 2015-10-31
	 *     ApplicableDays: Mon,Tue,Thr,Sat,Sun
	 * 
	 * Oct 1st = Thrusday (on day)
	 * Oct 2nd = Friday (off day)
	 * Oct 7th = Wednesday (on day)
	 */
	
    public function testGetNextDateTimeOnDay() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
		
		//Before
		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextDateTime());
	}
	
    public function testGetNextDateTimeOffDay() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');

		//After
		SS_Datetime::set_mock_now('2015-10-02 11:50:00');
		$this->assertEquals('2015-10-03 12:50:00', $sched->getNextDateTime());
	}
	
    public function testGetNextDateTimeDuring() {
		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
		
		//During
		SS_Datetime::set_mock_now('2015-10-03 12:30:00');
		$this->assertEquals('2015-10-03 13:30:00', $sched->getNextDateTime());
	}
}