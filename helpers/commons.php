<?php

require_once __DIR__ . '/config.php';
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

// Source: https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
function full_path()
{
    $s = &$_SERVER;
    $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on') ? true:false;
    $sp = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port = $s['SERVER_PORT'];
    $port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
    $host = isset($s['HTTP_X_FORWARDED_HOST']) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    $uri = $protocol . '://' . $host . $s['REQUEST_URI'];
    $segments = explode('?', $uri, 2);
    $url = $segments[0];
    return $url;
}

// Source: https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

