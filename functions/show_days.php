<?php

function showDays($vacation_start, $vacation_end) {
    $diff = abs(strtotime($vacation_start) - strtotime($vacation_end));
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    return $days;
}

function dateFormat() {
    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $today = $year . '-' . $month . '-' . $day;

    echo $today;
}
