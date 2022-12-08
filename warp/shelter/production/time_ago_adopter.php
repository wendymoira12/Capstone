<?php
$notifAt = $notifdate['adopternotif_date'];

function convertToUnixTimestamp($value){
    date_default_timezone_set('Asia/Manila');
    list($date, $time) = explode(' ', $value);
    list($year, $month, $day) = explode("-", $date);
    list($hour, $minutes, $seconds) = explode(":", "$time");

    $unit_timestamp = mktime($hour, $minutes, $seconds, $month, $day, $year);

    return $unit_timestamp;

}

function convertToAgoFormat($timestamp){
    //difference between current time and timestamp
    $diffBtwCurrTimeAndTimestamp = time() - $timestamp;
    $periodString = ["sec", "min", "hr", "day", "week", "month", "year", "decade"];
    $periodNUmber = ["60", "60", "24", "7", "4.35", "12", "10"];

    //iteration for the $periodNumber where yung 0 index is yung 60 sec, etc.
    for($iterator = 0; $diffBtwCurrTimeAndTimestamp >= $periodNUmber[$iterator]; $iterator++)
    $diffBtwCurrTimeAndTimestamp /= $periodNUmber[$iterator];
    $diffBtwCurrTimeAndTimestamp = round($diffBtwCurrTimeAndTimestamp);

    //lalagyan ng s pag hindi 1, sec magiging secs min magiging mins
    if($diffBtwCurrTimeAndTimestamp != 1) $periodString[$iterator].="s";

    $output = "$diffBtwCurrTimeAndTimestamp $periodString[$iterator]";

    return $output." ago";

}

$unixTimestamp = convertToUnixTimestamp($notifAt);
?>