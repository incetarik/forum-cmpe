<?php

require_once dirname(__DIR__) . '/helpers/config.php';
session_start();

function redirect($to)
{
    header("Location: $to");
}

function putPageData($name, $value)
{
    return $_POST[PAGE_DATA_PREFIX . $name] = $value;
}

function getPageData($name, $default_value = null)
{
    if (!isset($_POST[PAGE_DATA_PREFIX . $name])) return $default_value;
    return $_POST[PAGE_DATA_PREFIX . $name];
}

function extendPageData($name, $value)
{
    $array = getPageData($name, []);
    return array_push($array, $value);
}

function getUser()
{
    return $_SESSION[SESSION_KEY_USER];
}


