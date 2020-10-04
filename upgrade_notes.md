2020-10-04 03:36

# running php upgrade upgrade see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/ss3/upgrades/silverstripe-schedulizer
php /var/www/ss3/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code upgrade /var/www/ss3/upgrades/silverstripe-schedulizer/schedulizer  --root-dir=/var/www/ss3/upgrades/silverstripe-schedulizer --write -vvv
Array
(
    [0] => Running upgrades on "/var/www/ss3/upgrades/silverstripe-schedulizer/schedulizer"
    [1] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRangeDayTest.php...
    [2] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ScheduleRangeDayTest.php...
    [3] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRangeTest.php...
    [4] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ScheduleRangeTest.php...
    [5] => [2020-10-04 15:36:18] Applying RenameClasses to ConfiguredScheduleTest.php...
    [6] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ConfiguredScheduleTest.php...
    [7] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRangeDefault.php...
    [8] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ScheduleRangeDefault.php...
    [9] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRangeDay.php...
    [10] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ScheduleRangeDay.php...
    [11] => [2020-10-04 15:36:18] Applying RenameClasses to SchedulizerModelAdmin.php...
    [12] => [2020-10-04 15:36:18] Applying ClassToTraitRule to SchedulizerModelAdmin.php...
    [13] => [2020-10-04 15:36:18] Applying RenameClasses to ConfiguredSchedule.php...
    [14] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ConfiguredSchedule.php...
    [15] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRangeDayType.php...
    [16] => [2020-10-04 15:36:18] Applying ClassToTraitRule to ScheduleRangeDayType.php...
    [17] => [2020-10-04 15:36:18] Applying RenameClasses to ScheduleRange.php...
    [18] => 
    [19] => In NameResolver.php line 155:
    [20] => 
    [21] =>   [PhpParser\Error]
    [22] =>   Cannot use Datetime as Datetime because the name is already in use on line 13
    [23] => 
    [24] => 
    [25] => Exception trace:
    [26] =>   at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeVisitor/NameResolver.php:155
    [27] =>  PhpParser\NodeVisitor\NameResolver->addAlias() at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeVisitor/NameResolver.php:51
    [28] =>  PhpParser\NodeVisitor\NameResolver->enterNode() at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php:159
    [29] =>  PhpParser\NodeTraverser->traverseArray() at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php:101
    [30] =>  PhpParser\NodeTraverser->traverseNode() at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php:171
    [31] =>  PhpParser\NodeTraverser->traverseArray() at /var/www/ss3/upgrader/vendor/nikic/php-parser/lib/PhpParser/NodeTraverser.php:85
    [32] =>  PhpParser\NodeTraverser->traverse() at /var/www/ss3/upgrader/vendor/silverstripe/upgrader/src/UpgradeRule/PHP/PHPUpgradeRule.php:28
    [33] =>  SilverStripe\Upgrader\UpgradeRule\PHP\PHPUpgradeRule->transformWithVisitors() at /var/www/ss3/upgrader/vendor/silverstripe/upgrader/src/UpgradeRule/PHP/RenameClasses.php:78
    [34] =>  SilverStripe\Upgrader\UpgradeRule\PHP\RenameClasses->upgradeFile() at /var/www/ss3/upgrader/vendor/silverstripe/upgrader/src/Upgrader.php:61
    [35] =>  SilverStripe\Upgrader\Upgrader->upgrade() at /var/www/ss3/upgrader/vendor/silverstripe/upgrader/src/Console/UpgradeCommand.php:95
    [36] =>  SilverStripe\Upgrader\Console\UpgradeCommand->execute() at /var/www/ss3/upgrader/vendor/symfony/console/Command/Command.php:255
    [37] =>  Symfony\Component\Console\Command\Command->run() at /var/www/ss3/upgrader/vendor/symfony/console/Application.php:1009
    [38] =>  Symfony\Component\Console\Application->doRunCommand() at /var/www/ss3/upgrader/vendor/symfony/console/Application.php:273
    [39] =>  Symfony\Component\Console\Application->doRun() at /var/www/ss3/upgrader/vendor/symfony/console/Application.php:149
    [40] =>  Symfony\Component\Console\Application->run() at /var/www/ss3/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code:55
    [41] => 
    [42] => upgrade [-r|--rule RULE] [-p|--prompt] [-d|--root-dir ROOT-DIR] [-w|--write] [--] <path>
    [43] => 
)


------------------------------------------------------------------------
To continue, please use the following parameter: startFrom=Upgrade
e.g. php runme.php startFrom=Upgrade
------------------------------------------------------------------------
            
# running php upgrade upgrade see: https://github.com/silverstripe/silverstripe-upgrader
cd /var/www/ss3/upgrades/silverstripe-schedulizer
php /var/www/ss3/upgrader/vendor/silverstripe/upgrader/bin/upgrade-code upgrade /var/www/ss3/upgrades/silverstripe-schedulizer/schedulizer  --root-dir=/var/www/ss3/upgrades/silverstripe-schedulizer --write -vvv
Writing changes for 9 files
Running upgrades on "/var/www/ss3/upgrades/silverstripe-schedulizer/schedulizer"
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRangeDayTest.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRangeDayTest.php...
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRangeTest.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRangeTest.php...
[2020-10-04 15:44:14] Applying RenameClasses to ConfiguredScheduleTest.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ConfiguredScheduleTest.php...
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRangeDefault.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRangeDefault.php...
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRangeDay.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRangeDay.php...
[2020-10-04 15:44:14] Applying RenameClasses to SchedulizerModelAdmin.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to SchedulizerModelAdmin.php...
[2020-10-04 15:44:14] Applying RenameClasses to ConfiguredSchedule.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ConfiguredSchedule.php...
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRangeDayType.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRangeDayType.php...
[2020-10-04 15:44:14] Applying RenameClasses to ScheduleRange.php...
[2020-10-04 15:44:14] Applying ClassToTraitRule to ScheduleRange.php...
[2020-10-04 15:44:14] Applying UpdateConfigClasses to _config.yml...
modified:	tests/ScheduleRangeDayTest.php
@@ -1,4 +1,8 @@
 <?php
+
+use Sunnysideup\Schedulizer\ScheduleRangeDay;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use SilverStripe\Dev\SapphireTest;
 /**
  * Description of ScheduleRangeTest
  *
@@ -26,42 +30,42 @@
 	 */

     public function testGetNextDateTimeOnDay() {
-		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
+		$sched = $this->objFromFixture(ScheduleRangeDay::class, 'schedDay1');

 		//Before
-		SS_Datetime::set_mock_now('2015-10-02 04:50:00');
+		DBDatetime::set_mock_now('2015-10-02 04:50:00');
 		$this->assertEquals('2015-10-02 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

     public function testGetNextDateTimeOnDayOutOfTimeRange() {
-		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
+		$sched = $this->objFromFixture(ScheduleRangeDay::class, 'schedDay1');

 		//After
-		SS_Datetime::set_mock_now('2015-10-02 22:50:00');
+		DBDatetime::set_mock_now('2015-10-02 22:50:00');
 		$this->assertEquals('2015-10-03 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

     public function testGetNextDateTimeOffDay() {
-		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
+		$sched = $this->objFromFixture(ScheduleRangeDay::class, 'schedDay1');

 		//After
-		SS_Datetime::set_mock_now('2015-10-06 11:50:00');
+		DBDatetime::set_mock_now('2015-10-06 11:50:00');
 		$this->assertEquals('2015-10-09 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

 	public function testGetNextDateTimeOffDayOutOfTimeRange() {
-		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
+		$sched = $this->objFromFixture(ScheduleRangeDay::class, 'schedDay1');

 		//After
-		SS_Datetime::set_mock_now('2015-10-06 22:50:00');
+		DBDatetime::set_mock_now('2015-10-06 22:50:00');
 		$this->assertEquals('2015-10-09 05:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

     public function testGetNextDateTimeDuring() {
-		$sched = $this->objFromFixture('ScheduleRangeDay', 'schedDay1');
+		$sched = $this->objFromFixture(ScheduleRangeDay::class, 'schedDay1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-03 12:30:00');
+		DBDatetime::set_mock_now('2015-10-03 12:30:00');
 		$this->assertEquals('2015-10-03 13:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}
 }

modified:	tests/ScheduleRangeTest.php
@@ -1,4 +1,8 @@
 <?php
+
+use Sunnysideup\Schedulizer\ScheduleRange;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use SilverStripe\Dev\SapphireTest;
 /**
  * Description of ScheduleRangeTest
  *
@@ -20,36 +24,36 @@
 	 */

     public function testGetNextDateTimeBefore() {
-		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
+		$sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

 		//Before
-		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
+		DBDatetime::set_mock_now('2015-10-01 11:50:00');

 		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

     public function testGetNextDateTimeAfter() {
-		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
+		$sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

 		//After
-		SS_Datetime::set_mock_now('2015-10-06 11:50:00');
+		DBDatetime::set_mock_now('2015-10-06 11:50:00');
         $result = $sched->getNextDateTime();
 		$this->assertEquals(null, $result);
 	}

     public function testGetNextDateTimeDuring() {
-		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
+		$sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
+		DBDatetime::set_mock_now('2015-10-02 12:30:00');
 		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}

     public function testGetNextDateTimeDuringAfterTimeRange() {
-		$sched = $this->objFromFixture('ScheduleRange', 'sched1');
+		$sched = $this->objFromFixture(ScheduleRange::class, 'sched1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-02 17:30:00');
+		DBDatetime::set_mock_now('2015-10-02 17:30:00');
 		$this->assertEquals('2015-10-03 12:00:00', $sched->getNextDateTime()->Format('Y-m-d H:i:s'));
 	}
 }

modified:	tests/ConfiguredScheduleTest.php
@@ -1,4 +1,11 @@
 <?php
+
+use Sunnysideup\Schedulizer\ConfiguredSchedule;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use Sunnysideup\Schedulizer\ScheduleRange;
+use Sunnysideup\Schedulizer\ScheduleRangeDay;
+use Sunnysideup\Schedulizer\ScheduleRangeDefault;
+use SilverStripe\Dev\SapphireTest;
 /**
  * Description of ScheduleRangeTest
  *
@@ -42,107 +49,107 @@
 	 */

     public function testGetNextDateTimeBeforeSR() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//Before
-		SS_Datetime::set_mock_now('2015-10-01 11:50:00');
+		DBDatetime::set_mock_now('2015-10-01 11:50:00');
 		$this->assertEquals('2015-10-01 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRange::class, $sched->getCurrentSchedule());
 	}

     public function testGetNextDateTimeAfterSR() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched3');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched3');
 		// After
-		SS_Datetime::set_mock_now('2015-10-06 12:00:00');
+		DBDatetime::set_mock_now('2015-10-06 12:00:00');
 		$this->assertEquals('2015-10-08 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRange::class, $sched->getCurrentSchedule());

-		SS_Datetime::set_mock_now('2015-10-13 18:00:00');
+		DBDatetime::set_mock_now('2015-10-13 18:00:00');
 		$this->assertEquals('2015-10-16 05:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRangeDay::class, $sched->getCurrentSchedule());
 	}

     public function testGetNextDateTimeDuringSR() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-02 12:30:00');
+		DBDatetime::set_mock_now('2015-10-02 12:30:00');
 		$this->assertEquals('2015-10-02 13:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRange::class, $sched->getCurrentSchedule());
 	}

 	public function testGetNextDateTimeAfterSRD() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//During
-		SS_Datetime::set_mock_now('2015-11-01 12:00:00');
+		DBDatetime::set_mock_now('2015-11-01 12:00:00');
 		$this->assertEquals('2015-11-01 14:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRangeDefault', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRangeDefault::class, $sched->getCurrentSchedule());
 	}


     public function testGetNextDateTimeBeforeSR2() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//Before
-		SS_Datetime::set_mock_now('2015-10-02 01:30:00');
+		DBDatetime::set_mock_now('2015-10-02 01:30:00');
 		$this->assertEquals('2015-10-02 12:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRange::class, $sched->getCurrentSchedule());
 	}

     public function testGetNextDateTimeAfterSR2() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//After
-		SS_Datetime::set_mock_now('2015-10-05 17:30:00');
+		DBDatetime::set_mock_now('2015-10-05 17:30:00');
 		$this->assertEquals('2015-10-05 18:00:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRangeDay::class, $sched->getCurrentSchedule());
 	}

     public function testGetNextDateTimeDuringSR2() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-03 14:30:00');
+		DBDatetime::set_mock_now('2015-10-03 14:30:00');
 		$this->assertEquals('2015-10-03 15:30:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRange', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRange::class, $sched->getCurrentSchedule());
 	}

 	public function testGetNextDateTimeDuringSRButOvertime() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched1');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched1');

 		//During
-		SS_Datetime::set_mock_now('2015-10-03 16:45:00');
+		DBDatetime::set_mock_now('2015-10-03 16:45:00');
 		// triggers the day based rule, as Oct-03 is a saturday, meaning its range goes 5am -> 22pm, every 30 minutes
 		$this->assertEquals('2015-10-03 17:15:00', $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s'));
-		$this->assertEquals('ScheduleRangeDay', $sched->getCurrentSchedule());
+		$this->assertEquals(ScheduleRangeDay::class, $sched->getCurrentSchedule());
 	}

 	public function testPrecedence() {
-		$sched = $this->objFromFixture('ConfiguredSchedule', 'ConfigSched2');
+		$sched = $this->objFromFixture(ConfiguredSchedule::class, 'ConfigSched2');

 		$times = [];

-		SS_Datetime::set_mock_now('2015-10-22 23:55:00');
+		DBDatetime::set_mock_now('2015-10-22 23:55:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

-		SS_Datetime::set_mock_now('2015-10-23 00:00:00');
+		DBDatetime::set_mock_now('2015-10-23 00:00:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

-		SS_Datetime::set_mock_now('2015-10-23 05:00:00');
+		DBDatetime::set_mock_now('2015-10-23 05:00:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

-		SS_Datetime::set_mock_now('2015-10-23 23:55:00');
+		DBDatetime::set_mock_now('2015-10-23 23:55:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

-		SS_Datetime::set_mock_now('2015-10-24 04:00:00');
+		DBDatetime::set_mock_now('2015-10-24 04:00:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

-		SS_Datetime::set_mock_now('2015-10-24 23:55:00');
+		DBDatetime::set_mock_now('2015-10-24 23:55:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

 		// sunday evening
-		SS_Datetime::set_mock_now('2015-10-25 23:55:00');
+		DBDatetime::set_mock_now('2015-10-25 23:55:00');
 		$times[] = $sched->getNextScheduledDateTime()->Format('Y-m-d H:i:s');

 		$this->assertEquals('2015-10-23 06:00:00', $times[0]);

modified:	src/ScheduleRangeDay.php
@@ -2,8 +2,10 @@

 namespace Sunnysideup\Schedulizer;

-use CheckboxSetField;
+
 use DateInterval;
+use SilverStripe\Forms\CheckboxSetField;
+

 /**
  * A date range class that can hold:

modified:	src/SchedulizerModelAdmin.php
@@ -2,8 +2,12 @@

 namespace Sunnysideup\Schedulizer;

-use ModelAdmin;
-use SS_Datetime;
+
+
+use Sunnysideup\Schedulizer\ConfiguredSchedule;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use SilverStripe\Admin\ModelAdmin;
+

 /**
  * @author Stephen McMahon <stephen@symbiote.com.au>
@@ -13,7 +17,7 @@
 	private static $url_segment = 'schedulizer';

 	private static $managed_models = array(
-		'ConfiguredSchedule'
+		ConfiguredSchedule::class
 	);

 	private static $allowed_actions = array(
@@ -30,7 +34,7 @@
 			return 'Invalid date';
 		}
 		$date = date('Y-m-d H:i:s', $time);
-		SS_Datetime::set_mock_now($date);
+		DBDatetime::set_mock_now($date);

 		$dateTime = $schedule->getNextScheduledDateTime();
 		if ($dateTime) {

modified:	src/ConfiguredSchedule.php
@@ -2,12 +2,19 @@

 namespace Sunnysideup\Schedulizer;

-use DataObject;
-use Requirements;
-use LiteralField;
+
+
+
 use DateTime;
-use SS_Datetime;
-use RequiredFields;
+
+
+use Sunnysideup\Schedulizer\ScheduleRange;
+use SilverStripe\View\Requirements;
+use SilverStripe\Forms\LiteralField;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use SilverStripe\Forms\RequiredFields;
+use SilverStripe\ORM\DataObject;
+

 /**
  *
@@ -34,7 +41,7 @@
 	);

 	private static $has_many = array (
-		'ScheduleRanges'	=> 'ScheduleRange'
+		'ScheduleRanges'	=> ScheduleRange::class
 	);

 	/**
@@ -65,7 +72,7 @@
 	}

 	public function getNextScheduledDateTime() {
-		$now = new DateTime(SS_Datetime::now());
+		$now = new DateTime(DBDatetime::now());
 		$return = NULL;

 		//filter SpecificRanges by end date

modified:	src/ScheduleRangeDayType.php
@@ -2,7 +2,9 @@

 namespace Sunnysideup\Schedulizer;

-use DropdownField;
+
+use SilverStripe\Forms\DropdownField;
+

 /**
  * A date range class that can hold:

modified:	src/ScheduleRange.php
@@ -2,16 +2,27 @@

 namespace Sunnysideup\Schedulizer;

-use DataObject;
+
 use DateTime;
-use DateField;
-use ClassInfo;
-use TextField;
-use DropdownField;
-use ReadonlyField;
-use RequiredFields;
-use SS_Datetime;
+
+
+
+
+
+
+
 use DateInterval;
+use Sunnysideup\Schedulizer\ConfiguredSchedule;
+use SilverStripe\Forms\DateField;
+use Sunnysideup\Schedulizer\ScheduleRange;
+use SilverStripe\Core\ClassInfo;
+use SilverStripe\Forms\TextField;
+use SilverStripe\Forms\DropdownField;
+use SilverStripe\Forms\ReadonlyField;
+use SilverStripe\Forms\RequiredFields;
+use SilverStripe\ORM\FieldType\DBDatetime;
+use SilverStripe\ORM\DataObject;
+

 /**
  * A date range class that can hold:
@@ -50,7 +61,7 @@
 	);

 	private static $has_one = array(
-		'ConfiguredSchedule' => 'ConfiguredSchedule'
+		'ConfiguredSchedule' => ConfiguredSchedule::class
 	);

 	/**
@@ -115,7 +126,7 @@
 				$fields->removeByName($field->Name);
 			}

-			$rangeTypes = ClassInfo::subclassesFor('ScheduleRange');
+			$rangeTypes = ClassInfo::subclassesFor(ScheduleRange::class);

 			$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
 			$fields->addFieldToTab('Root.Main', DropdownField::create('ClassName', 'Range Type', $rangeTypes));
@@ -166,7 +177,7 @@
 	}

 	protected function getScheduleDateTime() {
-		$now = new Datetime(SS_Datetime::now()->Format(DateTime::ATOM));
+		$now = new Datetime(DBDatetime::now()->Format(DateTime::ATOM));
 		// get a start time for 'today'
 		$nextDateTime = $this->getStartDateTime();

@@ -227,7 +238,7 @@

         // we use $this->StartTime, because if we leave it as 'now' time, we may actually be closer to
         // the _next_ day, and the diff logic further on will instead return +1 day more than we expect.
-		$now = new Datetime(SS_Datetime::now()->Format('Y-m-d ' . $this->StartTime));
+		$now = new Datetime(DBDatetime::now()->Format('Y-m-d ' . $this->StartTime));

 		// make sure that the 'day' we start looking from is close to 'now' so our
 		// loops don't work through days that don't matter

modified:	_config/_config.yml
@@ -1,6 +1,7 @@
-ConfiguredSchedule:
+Sunnysideup\Schedulizer\ConfiguredSchedule:
   schedule_range_precedence:
-    - ScheduleRange
-    - ScheduleRangeDay
-    - ScheduleRangeDayType
-    - ScheduleRangeDefault
+    - Sunnysideup\Schedulizer\ScheduleRange
+    - Sunnysideup\Schedulizer\ScheduleRangeDay
+    - Sunnysideup\Schedulizer\ScheduleRangeDayType
+    - Sunnysideup\Schedulizer\ScheduleRangeDefault
+

Writing changes for 9 files
✔✔✔