<?php

require_once __DIR__ . '/index.php';

function _entry_like($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    return like_entry($user['id'], intval($params['entry']));
}

function _entry_dislike($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    return dislike_entry($user['id'], intval($params['entry']));
}

function _entry_create($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    $title = null;
    $categories = null;
    $tags = null;
    $content = null;
    $created_by = $user['id'];
    $created_by = intval($created_by);

    if (!array_key_exists('title', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "title" expected');
    }
    else $title = $params['title'];

    if (!array_key_exists('content', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "content" expected');
    }
    else $content = $params['content'];

    if (!array_key_exists('categories', $params)) {
        $categories = '';
    }
    else $categories = $params['categories'] or '';

    if (!array_key_exists('tags', $params)) {
        $tags = '';
    }
    else $tags = $params['tags'] or '';

    if (!$title || !strlen($title)) {
        throw new Error('Invalid title, title was empty');
    }

    if (!$content || !strlen($content)) {
        throw new Error('Invalid content, content was empty');
    }

    $categories = explode(',', $categories);
    $categories = array_map(function ($item) { return trim($item); }, $categories);
    $categories = implode(';', $categories);

    $tags = explode(',', $tags);
    $tags = array_map(function ($item) { return trim($item); }, $tags);
    $tags = implode(';', $tags);

    $value = create_entry($created_by, $title, $content, $categories, $tags);
    redirect('/');
}

function _entry_like_toggle($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    return toggle_like_entry($user['id'], intval($params['entry']));
}

function _entry_did_user_like($params) {
    $user = get_user();
    if (!$user) {
        var_dump($params);
        throw new Error('User not found');
    }

    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    return get_has_user_liked_entry($user['id'], intval($params['entry']));
}

function _entry_get_comments($params) {
    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    $entry_id = intval($params['entry']);
    if (isset($params['user'])) {
        $user_id = intval($params['user']);
        return get_comments_of_entry_by_user($user_id, $entry_id);
    }

    return get_comments_of_entry($entry_id);
}

function _entry_add_comment($params) {
    $user = get_user();

    if (!$user) {
        throw new Error('User not found');
    }

    if (!array_key_exists('entry', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "entry" expected');
    }

    if (!array_key_exists('title', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "title" expected');
    }

    if (!array_key_exists('content', $params)) {
        var_dump($params);
        throw new Error('Invalid parameters, "content" expected');
    }

    return add_comment_to_entry($user['id'], intval($params['entry']), $params['title'], $params['content']);
}

register_handler('like_entry', '_entry_like', 'p');
register_handler('dislike_entry', '_entry_dislike', 'p');
register_handler('create_entry', '_entry_create', 'p');
register_handler('toggle_like_entry', '_entry_like_toggle', 'p');
register_handler('user_did_like', '_entry_did_user_like', 'p');
register_handler('get_entry_comments', '_entry_get_comments', 'p');
register_handler('add_comment', '_entry_add_comment');

handle_request();
