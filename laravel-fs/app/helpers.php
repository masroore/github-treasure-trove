<?php

if (!function_exists('show_full_date')) {
    function show_full_date($date)
    {
        $split = explode(' ', $date);
        $d = explode('-', $split[0]);
        $date = $d[2] . '/' . $d[1] . '/' . $d[0];

        return $date . '    ' . $split[1];
    }
}

if (!function_exists('show_date')) { // Transform the date of Format 00-00-0000 to the Format 00/00/0000
    function show_date($date)
    {
        $date = explode('-', $date);

        return $date[2] . '/' . $date[1] . '/' . $date[0];
    }
}

if (!function_exists('textUpper')) {
    function textUpper($text)
    {
        return mb_strtoupper($text, 'UTF8');
    }
}

if (!function_exists('FullSerial')) {
    function FullSerial($serial, $zero = 6)
    {
        return str_pad($serial, $zero, '0', STR_PAD_LEFT);
    }
}
