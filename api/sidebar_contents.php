<?php

require_once __DIR__ . '/index.php';

function _sidebar_content_create($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    if (!array_key_exists('title', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "title" expected');
    }

    if (!array_key_exists('content', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "content" expected');
    }

    $title = $params['title'];
    $content = $params['content'];

    if (!$title || !strlen($title)) {
        throw new Error('Invalid @title');
    }

    if (!$content || !strlen($content)) {
        throw new Error('Invalid @content');
    }

    $id = $user['id'];
    $id = intval($id);
    create_sidebar_content($id, $title, $content);
    redirect('/');
}

function _sidebar_content_remove($params) {
    $user = get_user();

    if (!array_key_exists('key', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "key" expected');
    }

    if (!array_key_exists('id', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "id" expected');
    }

    $key = $params['key'];
    $id = $params['id'];
    $pairs = $_SESSION[SESSION_SIDEBAR_PAIRS];
    if (!array_key_exists($id, $pairs)) {
        throw new Error('Sidebar pair not found');
    }

    list($user_id, $stored_id) = $pairs[$id];
    if (!$user_id == $user['id']) throw new Error('User has no right to remove selected content');
    if ($stored_id != $key) {
        throw new Error("Remove keys are not matching. [$stored_id vs $key]");
    }

    $affected_rows = delete_sidebar_content($id);

    if ($affected_rows == 1) {
        unset($_SESSION[SESSION_SIDEBAR_PAIRS][$id]);
    }

    return $affected_rows;
}


register_handler('create', '_sidebar_content_create', 'p');
register_handler('delete', '_sidebar_content_remove', 'p');





handle_request();
