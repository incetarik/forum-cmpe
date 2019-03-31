<?php

function get_all_users_raw($fields = '*') {
    $db = get_db();
    $result = $db->query("SELECT $fields FROM users;");

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
    $db = get_db();
    $result = $db->query("SELECT $fields FROM users WHERE id = $id;");

    return $result;
}

function get_by_id($id, $fields = '*') {
    $result = get_by_id_raw($id, $fields);
    return $result->fetch_row();
}

function get_by_ids_raw($ids, $fields = '*') {
    $db = get_db();
    if (is_array($ids)) {
        $ids = implode(',', $ids);
    }
    else if (!is_string($ids)) {
        throw new UnexpectedValueException('$ids should be string or array');
    }

    $result = $db->query("SELECT $fields FROM users WHERE id IN $ids;");

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
    $db = get_db();
    $result = $db->query("SELECT $fields FROM users WHERE username = '$username';");

    return $result;
}

function get_user_by_username($username, $fields = '*') {
    $result = get_user_by_username_raw($username, $fields);
    return $result->fetch_row();
}

function get_user_by_email($email, $fields = '*') {
    $db = get_db();
    $result = $db->query("SELECT $fields FROM users WHERE email_address = '$email';");

    return $result;
}

function get_user_by_auth_raw($username, $password, $fields = '*') {
    $db = get_db();
    $results = $db->query("SELECT $fields FROM users WHERE username = '$username' AND password = SHA2('$password', 512);");

    return $results;
}

function get_user_by_auth($username, $password, $fields = '*') {
    $result = get_user_by_auth_raw($username, $password, $fields);
    return $result->fetch_row();
}

function is_username_available($username) {
    $db = get_db();
    $results = $db->query("SELECT username FROM users WHERE username = '$username' LIMIT 1;");
    return !$results->num_rows;
}

function is_email_available($email) {
    $db = get_db();
    $results = $db->query("SELECT email_address FROM users WHERE email_address = '$email';");
    return !$results->num_rows;
}

function register_user_raw($username, $password, $mail, $name, $surname)
{
    $db = get_db();
    $result = $db->query(<<<SQL
    INSERT INTO users (username, password, email_address, name, surname) 
    VALUES ('$username', SHA2('$password', 512), '$mail', '$name', '$surname');
SQL
    );

    return $result;
}

function register_user($username, $password, $mail, $name, $surname) {
    $result = register_user_raw($username, $password, $mail, $name, $surname);
    return $result;
}

