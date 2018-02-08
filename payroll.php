<?php
require_once 'autoload.php';

$handle = fopen("php://stdin", "r");

echo "To export all months in the current year, simply skip month, year and enter filename\n";
echo "Please enter month: ";
fscanf($handle, "%s", $month);
$calHelper = new Helpers\CalendarHelper;
$calMonths = $calHelper->getMonths();
//if user has entered a month
if (trim($month)) { 
    //check if valid month
    if (!in_array(strtolower($month), $calMonths)) {
        echo "Month invalid. Please try again\n";
        exit;
    } else {
        //convert month name to number
        $monthNumber = date("m", strtotime($month));
    }
}
echo "Please enter year: ";
fscanf($handle, "%i", $year);
// echo $year;
echo "Please enter filename to export: ";
fscanf($handle, "%s", $filename);

if (!trim($filename)) {
    echo "A filename is required\n";
}

if (!trim($year)) {
    $year = date("Y");
}

$result = array();
for ($i = 1; $i <= 12; $i++) {
    if (isset($monthNumber) && $i != $monthNumber) {
        continue;
    }
    $calHelper = new Helpers\CalendarHelper;
    $calHelper->setMonth($i);
    $calHelper->setNonFutureYear($year);
    $calHelper->setDayNumber(1);
    $result[$i]['monthName'] = $calHelper->getMonthName();
    $result[$i]['firstExpenseDay'] = $calHelper->getExpenseDay();
    $calHelper->setDayNumber(15);
    $result[$i]['secondExpenseDay'] = $calHelper->getExpenseDay();
    $result[$i]['salaryDay'] = $calHelper->getSalaryDay();

}

if (empty($result)) {
    echo "There are no data to export \n";
    exit;
}

//Export to csv file
$headers = ["Month Name", "1st expenses day", "2nd expenses day", "Salary day"];
$csvHelper = new Helpers\CsvHelper($result);
$csvHelper->setHeaders($headers);
$csvHelper->setFileName($filename);
$csvHelper->export();
