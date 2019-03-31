<?php

require_once __DIR__ . '/index.php';

function _user_check_username($params) {
    if (array_key_exists('username', $params)) {
        return is_username_available($params['username']);
    }

    var_dump($params);
    throw new Error('Invalid parameters, "username" expected');
}

function _user_check_email($params) {
    if (array_key_exists('mail', $params)) {
        return is_email_available($params['mail']);
    }

    var_dump($params);
    throw new Error('Invalid parameters, "email" expected');
}

function _user_register($params) {
    $username = null;
    $password = null;
    $mail = null;

    if (!array_key_exists('username', $params)) goto error;
    if (!array_key_exists('password', $params)) goto error;
    if (!array_key_exists('email', $params)) goto error;
    if (!array_key_exists('name', $params)) goto error;
    if (!array_key_exists('surname', $params)) goto error;
    if (!array_key_exists('validationToken', $params)) goto error;

    $username = $params['username'];
    $password = $params['password'];
    $mail = $params['email'];
    $name = $params['name'];
    $surname = $params['surname'];
    $validationToken = $params['validationToken'];

    if ($validationToken !== $_SESSION['__register_form_validation']) {
        throw new Error('Invalid token');
    }

    $value = register_user($username, $password, $mail, $name, $surname);
    if (!$value) {
        return false;
    }

    return true;

    error:
    var_dump($params);
    throw new Error('Invalid parameters');
}

function _user_login($params) {
    $username = null;
    $password = null;

    if (!array_key_exists('username', $params)) goto error;
    if (!array_key_exists('password', $params)) goto error;

    $username = $params['username'];
    $password = $params['password'];

    $user = get_user_by_auth($username, $password);
    if (!$user) return false;

    $_SESSION[SESSION_KEY_USER] = $user;

    return $user;

    error:
    var_dump($params);
    throw new Error('Invalid parameters');
}

register_handler('login', '_user_login');
register_handler('register', '_user_register');
register_handler('check_mail', '_user_check_email');
register_handler('check_username', '_user_check_username');






handle_request();
