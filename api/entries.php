<?php

require_once __DIR__ . '/index.php';

function _entry_like($params) {
    $user = getUser();
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
    $user = getUser();
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


register_handler('like_entry', '_entry_like', 'p');
register_handler('dislike_entry', '_entry_dislike', 'p');




handle_request();
