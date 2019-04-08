<?php

require_once __DIR__ . '/db_helper.php';

function get_all_users_raw($fields = '*') {
    $result = safe_query("SELECT $fields FROM users;", true);
    return $result;
}

function iterate_users($fields = '*') {
    $result = get_all_users_raw($fields);
    $values = $result->fetch_all(MYSQLI_BOTH);
    foreach ($values as $value) {
        yield $value;
    }
}

function get_by_id_raw($id, $fields = '*') {
    $result = safe_query("SELECT $fields FROM users WHERE id = ?;", [$id], true);
    return $result;
}

function get_by_id($id, $fields = '*') {
    $result = get_by_id_raw($id, $fields);
    return $result->fetch_row();
}

function get_by_ids_raw($ids, $fields = '*') {
    $db = get_db();

    if (is_string($ids)) {
        $ids = explode(',', $ids);
    }
    else if (!is_array($ids)) {
        throw new UnexpectedValueException('$ids should be string or array');
    }

    $parameters = implode(',', array_fill(0, count($ids), '?'));
    $result = safe_query("SELECT $fields FROM users WHERE id IN ($parameters);", $parameters, true);

    return $result;
}

function iterate_users_by_id($ids, $fields = '*') {
    $result = get_by_ids_raw($ids, $fields);
    $values = $result->fetch_all(MYSQLI_BOTH);
    foreach ($values as $value) {
        yield $value;
    }
}

function get_user_by_username_raw($username, $fields = '*') {
    $result = safe_query("SELECT $fields FROM users WHERE username = ?;", $username, true);
    return $result;
}

function get_user_by_username($username, $fields = '*') {
    $result = get_user_by_username_raw($username, $fields);
    return $result->fetch_row();
}

function get_user_by_email($email, $fields = '*') {
    $result = safe_query("SELECT $fields FROM users WHERE email_address = ?;", $email, true);
    return $result;
}

function get_user_by_auth_raw($username, $password, $fields = '*') {
    $result = safe_query("SELECT $fields FROM users WHERE username = ? AND password = SHA2(?, 512);", [$username, $password], true);
    return $result;
}

function get_user_by_auth($username, $password, $fields = '*') {
    $result = get_user_by_auth_raw($username, $password, $fields);
    return $result->fetch_row();
}

function is_username_available($username) {
    $result = safe_query("SELECT username FROM users WHERE username = ? LIMIT 1;", $username, true);
    return !$result->num_rows;
}

function is_email_available($email) {
    $result = safe_query("SELECT email_address FROM users WHERE email_address = ?;", $email, true);
    return !$result->num_rows;
}

function register_user_raw($username, $password, $mail, $name, $surname)
{
    $result = safe_query(<<<SQL
    INSERT INTO users (username, password, email_address, name, surname)
    VALUES (?, SHA2(?, 512), ?, ?, ?);
SQL
, [$username, $password, $mail, $name, $surname], true);

    return $result;
}

function register_user($username, $password, $mail, $name, $surname) {
    $result = register_user_raw($username, $password, $mail, $name, $surname);
    return $result;
}

