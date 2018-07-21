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

// client functions
function currentClient()
{
    session_start_safe();
    if (isset($_SESSION['client_id'])) {
        return ClientQuery::create()->findPk($_SESSION['client_id']);
    }
    return null;
}

function replaceLast($replace_this, $with_this, $original)
{
    $pos = strrpos($original, $replace_this);
    if ($pos !== false) {
        $original = substr_replace($original, $with_this, $pos, strlen($replace_this));
    }
    return $original;
}
