# SilverStripe Schedulizer module

Fun module for organising stuff to happen at arbitrary times in the future.

## Maintainer Contacts

* Stephen McMahon <stephen@symbiote.com.au>
* Marcus Nyeholt <marcus@symbiote.com.au>

## Requirements

* SilverStripe 3.1


## Usage

* Create a Configured Schedule via the CMS admin
* From code, call 
  * `ConfiguredSchedule::get()->filter('Title', $name)->first()->getNextScheduledDateTime();`

## Configuring schedules

For a job, schedules are read in particular precedence; first, the 'default' schedule is loaded. 
All other schedules are evaluated to see if they are applicable for the "current" time; if so, the desired schedule is substituted for, in increasing order of importance

* A ScheduleRangeDayType (ie weekday, Weekend)
* A ScheduleRangeDay (ie Monday, Tuesday)
* A ScheduleRange (ie specific date)

This allows configuration of a schedule set that is, for example

* Default - 6am - 6pm every day until 2020
* Weekends - 9am - 5pm
* Thursday - 6am - 9pm
* 25/12/2015 - 10am - 2pm

The decided upon schedule evaluates each in order, and selects that which is most specific. 

**Create a schedule**

* Open `admin/schedulizer/`. 
* Create a new schedule - for QueuedJobs usage, use the same name as the job classname
* Create a new Schedule Range; the first one should be called "Default" and have a type of 
  "ScheduleRangeDefault". This is the baseline schedule that will be used 
* Add additional schedules if needed
* Test the schedule by entering a date/time (YYYY-MM-DD hh:mm:ss format) and clicking "Test" - 
  this will update with the next detected 'tick' time for that schedule. 

**Modifying a schedule**

* Open  `admin/schedulizer/`
* Select the schedule to modify
* On the "Schedule Ranges" tab, select the schedule to modify
* Modify the relevant fields
* Save and close, then test the new schedule as above. 

## License

This module is licensed under the BSD license at http://silverstripe.org/BSD-license

