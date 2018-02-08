<?php
namespace Helpers;

class CalendarHelper
{
    private $expenseDays = ["monday"];
    private $salaryDays = ["monday", "tuesday", "wednesday", "thursday", "friday"];
    private $dayNumber;
    private $monthName;
    private $monthNumber;
    private $year;
    private $date;
    private $months = [
        "january", 
        "february", 
        "march", 
        "april", 
        "may", 
        "june", 
        "july", 
        "august", 
        "september", 
        "october", 
        "november", 
        "december"
    ];


    public function setMonth($month)
    {
        if (!is_numeric($month)) {
            throw new \Exception("Numeric value of month is required");
        }

        if ($month < 1 || $month > 12) {
            throw new \Exception("Month not valid");
        }

        $jd = gregoriantojd($month,1,date("Y"));
        $monthName = jdmonthname($jd, 1);
        $this->monthName = $monthName;
        $this->monthNumber = sprintf("%02d", $month);
    }

    public function setNonFutureYear($year)
    {
        if ($year > date("Y")) {
            throw new \Exception("Cannot set year in the future");
        }

        if (strlen($year) <> 4 || $year < 1900) {
            throw new \Exception("Invalid year");
        }

        $this->year = (int) $year;
    }

    public function getLastDayofMonth()
    {
        return date("Y-m-d", strtotime("last day of $this->monthName $this->year"));
    }

    public function getSalaryDay()
    {
        if ($this->dayNumber) {
            $lastday = $this->year."-".$this->monthNumber."-".$this->dayNumber;
        } else {
            $lastday = date("Y-m-d", strtotime("last day of ".$this->monthName." ".$this->year));
            $this->dayNumber = date("d", strtotime($lastday));
        }

        $str_date = strtotime($lastday);
        $day = date("l", $str_date);
        // echo "month: ".$this->monthName."\n";
        // echo "day: ".$day."\n";

        if (in_array(strtolower($day), $this->salaryDays)) {
            // echo "date: ".$date."\n";
            return $lastday;
        }

        $this->dayNumber = sprintf("%02d", ($this->dayNumber - 1));
        return $this->getSalaryDay();
    }

    public function getExpenseDay()
    {
        if ($this->dayNumber) {
            $date = $this->year."-".$this->monthNumber."-".$this->dayNumber;
        } else {
            $date = $this->year."-".$this->monthNumber."-01";
        }

        $str_date = strtotime($date);
        $day = date("l", $str_date);

        if (in_array(strtolower($day), $this->expenseDays)) {
            return $date;
        }

        $this->dayNumber++;
        $this->dayNumber = sprintf("%02d", ($this->dayNumber));
        return $this->getExpenseDay();
    }

    public function setDayNumber($dayNumber)
    {
        if (!is_int($dayNumber)) {
            throw new \Exception("Day is number only");
        }
        $this->dayNumber = (int) sprintf("%02d", $dayNumber);
    }

    public function getMonthName()
    {
        return $this->monthName;
    }

    public function getMonths()
    {
        return $this->months;
    }


}
