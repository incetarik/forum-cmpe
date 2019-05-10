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

function _user_update($params) {
    $user = get_user();
    if (!$user) throw new Error('User not logged in');
    if (!isset($_SESSION['__update_form_validation'])) throw new Error("No validation provided");
    if (!array_key_exists('__update_form_validation', $params)) throw new Error('Invalid form');
    if ($params['__update_form_validation'] != $_SESSION['__update_form_validation'])
        throw new Error('Validation mismatch');

    $_SESSION['__update_form_validation'] = null;

    $id = $user['id'];
    $id = intval($id);

    $name = null;
    $surname = null;
    $email_address = null;
    $job_title = null;
    $password = null;

    if (isset($params['name'])) $name = $params['name'];
    if (isset($params['surname'])) $surname = $params['surname'];
    if (isset($params['email'])) $email_address = $params['email'];
    if (isset($params['jobTitle'])) $job_title = $params['jobTitle'];
    if (isset($params['password'])) $password = $params['password'];

    $result = update_user($id, $name, $surname, $email_address, $job_title, $password);
    $_SESSION[SESSION_KEY_USER] = get_user_by_username($user['username']);
    return $result;
}

register_handler('login', '_user_login');
register_handler('register', '_user_register');
register_handler('check_mail', '_user_check_email');
register_handler('check_username', '_user_check_username');
register_handler('update', '_user_update');





handle_request();
