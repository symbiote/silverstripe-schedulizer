<?php

namespace Sunnysideup\Schedulizer\Model;

use DateInterval;







use DateTime;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * A date range class that can hold:
 * - specific date range (e.g 01/01/2015 to 29/01/2015
 * - specific day range (e.g Mon to Friday)
 * - specific day type range (e.g Weekday or Weekend)
 *
 * @author Stephen McMahon <stephen@symbiote.com.au>
 */
class ScheduleRange extends DataObject
{
    /**
     * The day we're at in a Range when looking for the next valid.
     * @var int
     */
    protected $day = 0;

    private static $table_name = 'ScheduleRange';

    private static $db = [
        'Title' => 'Varchar',
        //Seconds between scheduled times
        'Interval' => 'Int',
        'StartTime' => 'Time',
        'EndTime' => 'Time',
        'StartDate' => 'Date',
        'EndDate' => 'Date',
        //Days this schedule is valid (e.g 'Monday,Tuesday,Wednesday,Thrusday,Friday,Weekend,Weekday')
        'ApplicableDays' => 'Varchar',
    ];

    private static $has_one = [
        'ConfiguredSchedule' => ConfiguredSchedule::class,
    ];

    public function __accessForgetScheduleDay()
    {
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('ConfiguredScheduleID');

        $interval = $fields->dataFieldByName('Interval')
            ->setDescription('Number of seconds between each run. e.g 3600 is 1 hour');
        $fields->replaceField(
            'Interval',
            $interval
        );

        $dt = new DateTime();

        $fields->replaceField(
            'StartDate',
            DateField::create('StartDate')
        );

        $fields->replaceField(
            'EndDate',
            DateField::create('EndDate')
        );

        if ($this->ID === null) {
            foreach ($fields->dataFields() as $field) {
                //delete all included fields
                $fields->removeByName($field->Name);
            }

            $rangeTypes = ClassInfo::subclassesFor(ScheduleRange::class);

            $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Title'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ClassName', 'Range Type', $rangeTypes));
        } else {
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('ClassName', 'Type'));
        }

        if ($this->ClassName === __CLASS__) {
            $fields->removeByName('ApplicableDays');
        }

        return $fields;
    }

    public function getCMSValidator()
    {
        $fields = ['Title'];
        if ($this->ID) {
            $fields = [
                'Title',
                'Interval',
                'StartTime',
                'EndTime',
                'StartDate',
                'EndDate',
            ];
        }
        return new RequiredFields($fields);
    }

    /**
     * Detrimines the next valid time and date for this schedule to execute
     *
     * @return DateTime|null DateTime
     */
    public function getNextDateTime() : ?DateTime
    {
        $this->day = 0;
        return $this->getScheduleDateTime();
    }

    public function getStartDateTime(): Datetime
    {
        return new Datetime($this->getScheduleDay() . ' ' . $this->StartTime);
    }

    /**
     * The end time for the start/end block
     * @return \Datetime
     */
    public function getEndDateTime(): Datetime
    {
        return new Datetime($this->getScheduleDay() . ' ' . $this->EndTime);
    }

    /**
     * The end time for the start/end block
     * @return \Datetime
     */
    public function getLastScheduleTime(): Datetime
    {
        return new Datetime($this->EndDate . ' ' . $this->EndTime);
    }

    /**
     *
     * @return Datetime|null
     */
    protected function getScheduleDateTime() : ?Datetime
    {
        $now = new Datetime(DBDatetime::now()->Format(DateTime::ATOM));
        // get a start time for 'today'
        $nextDateTime = $this->getStartDateTime();

        if ($now >= $nextDateTime) {
            //Inside the ScheduleRange so set nextDateTime to now + interval
            $nextDateTime = $now->add(new DateInterval('PT' . $this->Interval . 'S'));
        }

        // and an end-time for 'today'
        $todayEndTime = $this->getEndDateTime();

        $lastEndTime = $this->getLastScheduleTime();

        if ($nextDateTime > $todayEndTime) {
            //Now + interval falls outside the Schedule range
            if ($nextDateTime > $lastEndTime) {
                $nextDateTime = null;
            } else {
                $this->goToNextDay();
                $nextDateTime = $this->getScheduleDateTime();
            }
        }

        // lastly, compare the very last date time.
        if ($nextDateTime > $lastEndTime) {
            $nextDateTime = null;
        }

        return $nextDateTime;
    }

    protected function getScheduleDay() : ?Datetime
    {
        $scheduleDay = new Datetime($this->StartDate . ' ' . $this->StartTime);

        // we use $this->StartTime, because if we leave it as 'now' time, we may actually be closer to
        // the _next_ day, and the diff logic further on will instead return +1 day more than we expect.
        $now = new Datetime(DBDatetime::now()->format('yyyy-MM-dd ' . $this->StartTime));

        // make sure that the 'day' we start looking from is close to 'now' so our
        // loops don't work through days that don't matter
        if (! $this->day && $now > $scheduleDay) {
            //a = Total number of days as a result of a DateTime::diff() or (unknown) otherwise
            //r = 	Sign "-" when negative, empty when positive
            $diff = $now->diff($scheduleDay)->format('%r%a');
            $this->day = abs($diff);
        }

        $scheduleDay->add(new DateInterval("P{$this->day}D"));

        return $scheduleDay->format('Y-m-d');
    }

    protected function goToNextDay()
    {
        $this->day++;
    }
}
