<?php

$config['displayErrorDetails'] = true;

function websiteName()
{
    return "Aszend";
}

function adminWebsiteName()
{
    return "Aszend Admin";
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

// client functions
function currentClient()
{
    session_start_safe();
    if (isset($_SESSION['client_id'])) {
        return ClientQuery::create()->findPk($_SESSION['client_id']);
    }
    return null;
}

function logClientIn($id)
{
    session_start_safe();
    $_SESSION['client_id'] = $id;
}

function logClientOut()
{
    session_start_safe();
    unset($_SESSION['client_id']);
}

function clearWebsitePay()
{
    session_start_safe();
    unset($_SESSION['paypal_website_id']);
}

// admin functions
function currentAdmin()
{
    session_start_safe();
    if (isset($_SESSION['admin_id'])) {
        return AdminQuery::create()->findPk($_SESSION['admin_id']);
    }
    return null;
}

function logAdminIn($id)
{
    session_start_safe();
    $_SESSION['admin_id'] = $id;
}

function logAdminOut()
{
    session_start_safe();
    unset($_SESSION['admin_id']);
}

// toggle monthly hosting button helper
function getColor($on = true)
{
    return $on?"btn-primary active":"btn-default";
}


// To get whole url and not just the path
function url()
{
    return urlFront() . $_SERVER['REQUEST_URI'];
}

function urlFront()
{
    if (isset($_SERVER['HTTPS'])) {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    } else {
        $protocol = 'http';
    }

    return $protocol . "://" . $_SERVER['HTTP_HOST'];
}


function startsWith($original, $substr)
{
    $length = strlen($substr);
    return (substr($original, 0, $length) === $substr);
}

function endsWith($original, $substr)
{
    $length = strlen($substr);

    return $length === 0 ||
    (substr($original, -$length) === $substr);
}

function modifyUrl($mod = array(), $url = false)
{
    // If $url wasn't passed in, use the current url
    if ($url == false) {
        $url = url();
    }

    // Parse the url into pieces
    $url_array = parse_url($url);

    // The original URL had a query string, modify it.
    if (!empty($url_array['query'])) {
        parse_str($url_array['query'], $query_array);
        foreach ($mod as $key => $value) {
            $query_array[$key] = $value;
        }
    }

    // The original URL didn't have a query string, add it.
    else {
        $query_array = $mod;
    }

    return $url_array['scheme'].'://'.$url_array['host'].$url_array['path'].'?'.http_build_query($query_array);
}

// date functions
// returns "x min ago, x hours ago, x days ago, etc"
function timeAgo($timestamp)
{
    $date1 = timestampToDate($timestamp);
    $date2 = getCurrentDateTime();
    $diff = dateDifference($date1, $date2);

    $time = "just now";

    if ($diff->y > 0) {
        $time = $diff->y." year".(($diff->y>1)?"s":""). " ago";
        $color = "default";
    } elseif ($diff->m > 0) {
        $time = $diff->m." month".(($diff->m>1)?"s":""). " ago";
        $color = "warning";
    } elseif ($diff->d > 0) {
        $time = $diff->d." day".(($diff->d>1)?"s":""). " ago";
        $color = "primary";
    } elseif ($diff->h > 0) {
        $time = $diff->h." hour".(($diff->h>1)?"s":""). " ago";
        $color = "info";
    } elseif ($diff->i >= 0) {
        if ($diff->i < 5) {
            $time = "just now";
            $color = "success";
        } else {
            $time = $diff->i." minutes ago";
            $color = "success";
        }
    }

    return array($color, $time);
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

function timestampToDate($time)
{
    $dt = getCurrentDateTime();
    $dt->setTimestamp($time);
    return $dt;
}

// get the difference between 2 dates
// $date2 >= $date1
function dateDifference($date1, $date2, $interval = 'm')
{
    if (is_int($date1)) {
        $date1 = timestampToDate($date1);
    }
    if (is_int($date2)) {
        $date2 = timestampToDate($date2);
    }

    return $date1->diff($date2);
}

// the functions below take strings such as "1/30/2017"
// for parameters (first second of the date)
function startOfDate($date_str)
{
    $date = DateTime::createFromFormat(
        'm/d/Y',
        $date_str,
    new DateTimeZone("Canada/Saskatchewan")
    );

    $date->setTime(0, 0);
    return $date;
}

// last second of the date
function endOfDate($date_str)
{
    $date = startOfDate($date_str);
    // add 1 day, then subtract a second
    $date->add(new DateInterval("P1D"));
    $date->sub(new DateInterval("PT1S"));
    return $date;
}

function startOfToday()
{
    return startOfDate(getCurrentDate()->format('m/d/Y'));
}

// add time interval to date
function add($date, $interval = 'M')
{
    return $date->add(new DateInterval("P1".$interval));
}

// remove months from date
function sub($date, $interval = 'M', $amount = 3)
{
    return $date->sub(new DateInterval("P".$amount.$interval));
}
