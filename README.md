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

## License

This module is licensed under the BSD license at http://silverstripe.org/BSD-license

