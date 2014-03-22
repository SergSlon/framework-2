<?php
namespace Calendar\Controller;

use Calendar\Model\LeapYear;

class LeapYearController
{
    public function indexAction($year)
    {
        $leapyear = new LeapYear();
        if ($leapyear->isLeapYear($year)) {
            return 'Yep, this is a leap year!';
        }

        return 'Nope, this is not a leap year.';
    }
}
