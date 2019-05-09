<?php

require_once __DIR__ . '/config.php';
session_start();

/**
 * Redirects to specific address with `Location` header.
 * @param $to string Target address.
 */
function redirect($to)
{
    header("Location: $to");
}

/**
 * Puts data to specific page data. So any data can be send to new page.
 * @param $name string Name of the data group.
 * @param $value mixed Data.
 * @return mixed The data.
 */
function put_page_data($name, $value)
{
    return $_POST[PAGE_DATA_PREFIX . $name] = $value;
}

/**
 * @param $name string Name of the data group.
 * @param mixed|null $default_value The default value if data could not be found.
 * @return mixed|null The data.
 */
function get_page_data($name, $default_value = null)
{
    if (!isset($_POST[PAGE_DATA_PREFIX . $name])) return $default_value;
    return $_POST[PAGE_DATA_PREFIX . $name];
}

/**
 * Extends by creating or pushing back a new item into a data group.
 * @param $name string Name of the data group.
 * @param $value mixed Value to extend data group.
 * @return int The new size of the page data.
 */
function extend_page_data($name, $value)
{
    $array = get_page_data($name, []);
    return array_push($array, $value);
}

/**
 * Gets user from the session or returns null if not found.
 * @return mixed|null User or null
 */
function get_user()
{
    if (array_key_exists(SESSION_KEY_USER, $_SESSION)) {
        return $_SESSION[SESSION_KEY_USER];
    }

    return null;
}

/**
 * Redirects to specific address if user has logged in.
 * @param $to string Target address to redirect.
 * @param bool $should_die Kills the interpreter if true.
 * @return bool True if redirect has been done.
 */
function redirect_user_if_logged_in($to, $should_die = false) {
    if (get_user()) {
        redirect($to);
        if ($should_die) die;
        return true;
    }

    return false;
}

function redirect_to_login_if_not_logged_in($to = '/login.php') {
    if (get_user()) return false;
    redirect($to);
    return true;
}

// Source: https://stackoverflow.com/questions/6768793/get-the-full-url-in-php
/**
 * @return string Full path of the url
 */
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
/**
 * @return string New UUID
 */
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

