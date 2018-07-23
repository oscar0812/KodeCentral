<?php

$config['displayErrorDetails'] = true;

function websiteName()
{
    return "Kode Central";
}

function copyright()
{
    return "Copyright © 2018. All Rights Reserved.";
}

function session_start_safe()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

function replaceLast($replace_this, $with_this, $original)
{
    $pos = strrpos($original, $replace_this);
    if ($pos !== false) {
        $original = substr_replace($original, $with_this, $pos, strlen($replace_this));
    }
    return $original;
}

function getCurrentDateTime()
{
    $dt = new DateTime();
    $dt->setTimezone(new DateTimeZone("Canada/Saskatchewan"));
    return $dt;
}

function getCurrentDate()
{
    $today = getCurrentDateTime();
    $today->setTime(0, 0);
    return $today;
}

function getCurrentTime()
{
    return getCurrentDateTime()->getTimestamp();
}
