<?php
/**
 * Description of ScheduleRangeTest
 *
 * @author Stephen McMahon <stephen@silverstripe.com.au>
 */
class ScheduleRangeTest extends SapphireTest {
	
	static $fixture_file = 'schedulizer/tests/ScheduleRange.yml';
	
    public function testGetNextDateTimeBefore() {
		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
		
		//Before
		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextDateTime());
	}
	
    public function testGetNextDateTimeAfter() {
		$sched = $this->objFromFixture('ScheduleRange', 'sched1');

		//After
		SS_Datetime::set_mock_now('2015-10-03 11:50:00');
		$this->assertEquals(null, $sched->getNextDateTime());
	}
	
    public function testGetNextDateTimeDuring() {
		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
		
		//During
		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextDateTime());
	}
}