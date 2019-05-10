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
    return $result->fetch_assoc();
}

function get_by_ids_raw($ids, $fields = '*') {
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
    return $result->fetch_assoc();
}

function get_user_by_email($email, $fields = '*') {
    $result = safe_query("SELECT $fields FROM users WHERE email_address = ?;", $email, true);
    return $result;
}

function get_user_by_auth_raw($username, $password, $fields = '*') {
    $password = hash('sha512', $password);
    $result = safe_query("SELECT $fields FROM users WHERE username = ? AND password = ?", [$username, $password], true);
    $result = $result->fetch_all(MYSQLI_BOTH);
    if (!count($result)) return false;
    return $result[0];
}

function get_user_by_auth($username, $password, $fields = '*') {
    $result = get_user_by_auth_raw($username, $password, $fields);
    return $result;
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
    $password = hash('sha512', $password);
    $result = safe_query(<<<SQL
    INSERT INTO users (username, password, email_address, name, surname)
    VALUES (?, ?, ?, ?, ?);
SQL
, [$username, $password, $mail, $name, $surname], true);

    return $result;
}

function register_user($username, $password, $mail, $name, $surname) {
    $result = register_user_raw($username, $password, $mail, $name, $surname);
    return $result;
}

function get_user_full_name($id) {
    $result = safe_query("SELECT name, surname FROM users WHERE id = ?;", [ $id ], true);
    $value = $result->fetch_assoc();
    if ($value and sizeof($value)) {
        return "{$value['name']} {$value['surname']}";
    }

    return '';
}

function update_user($id, $name = null, $surname = null, $email = null, $job_title = null, $password = null) {
    $sql = "UPDATE users SET";
    $update_params = [];

    if ($name) {
        $sql .= ' name = ?, ';
        array_push($update_params, $name);
    }

    if ($surname) {
        $sql .= ' surname = ?, ';
        array_push($update_params, $surname);
    }

    if ($email) {
        $sql .= ' email = ?, ';
        array_push($update_params, $email);
    }

    if ($job_title) {
        $sql .= ' job_title = ?, ';
        array_push($update_params, $job_title);
    }

    if ($password) {
        $sql .= ' password = ?, ';
        array_push($update_params, hash('sha512', $password));
    }

    if (!sizeof($update_params)) {
        return false;
    }


    $sql = substr($sql,0, strlen($sql) - 2);
    $sql .= ' WHERE id = ?';
    array_push($update_params, $id);

    $result = safe_query($sql, $update_params, true);
    if (is_bool($result)) return $result;
    $value = $result->fetch_assoc();
    return $value;
}
