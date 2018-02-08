<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use Helpers\CalendarHelper;

final class CalendarHelperTest extends TestCase
{

    public function testGetSalaryDay()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setMonth(9);
        $calHelper->setNonFutureYear(2018);
        $workDay = $calHelper->getSalaryDay();
        $this->assertEquals($workDay, "2018-09-28");
    }

    /**
    * @expectedException        Exception
    * @expectedExceptionMessage Numeric value of month is required
    */
    public function testGetLastDayOfMonthReturnErrorOnInvalidMonth()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setMonth("apple");
    }

    public function testGetDateOfFirstExpenseDay()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setMonth(1);
        $calHelper->setNonFutureYear(2018);
        $workingDay = $calHelper->getExpenseDay();
        $this->assertEquals($workingDay, "2018-01-01");
        $calHelper->setMonth(2);
        $workingDay = $calHelper->getExpenseDay();
        $this->assertEquals($workingDay, "2018-02-05");
    }

    public function testGetDateOfSecondExpenseDay()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setDayNumber(15);
        $calHelper->setMonth(10);
        $calHelper->setNonFutureYear(2018);
        $workingDay = $calHelper->getExpenseDay();
        $this->assertEquals($workingDay, "2018-10-15");
        $calHelper->setMonth(11);
        $workingDay = $calHelper->getExpenseDay();
        $this->assertEquals($workingDay, "2018-11-19");
    }

    /**
    * @expectedException        Exception
    * @expectedExceptionMessage Cannot set year in the future
    */
    public function testReturnErrorWithFutureYear()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setNonFutureYear(date("Y", strtotime("next year")));
    }

    /**
    * @expectedException        Exception
    * @expectedExceptionMessage Invalid year
    */
    public function testReturnErrorWithInvalidYear()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setNonFutureYear(100);
    }

    public function testGetMonthName()
    {
        $calHelper = new CalendarHelper;
        $calHelper->setMonth(2);
        
        $this->assertEquals("February", $calHelper->getMonthName());
    }



}
