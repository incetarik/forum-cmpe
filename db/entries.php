<?php

require_once __DIR__ . '/db_helper.php';

function get_all_entries_raw($fields = '*') {
    $result = safe_query("SELECT $fields FROM entries;", true);
    return $result;
}

function iterate_entries($fields = '*') {
    $result = get_all_entries_raw($fields);
    $values = $result->fetch_all(MYSQLI_BOTH);
    foreach ($values as $value) {
        yield $value;
    }
}

function like_entry($user_id, $entry_id) {
    $result = safe_query("SELECT id FROM entry_likes WHERE user_id = ? AND entry_id = ? LIMIT 1;", [ $user_id, $entry_id ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);

    if (count($values)) return false;
    $result = safe_query("INSERT INTO entry_likes (user_id, entry_id) VALUES (?, ?);", [ $user_id, $entry_id ], true);
    return $result;
}

function dislike_entry($user_id, $entry_id) {
    $result = safe_query("DELETE FROM entry_likes WHERE user_id = ? AND entry_id = ?;", [ $user_id, $entry_id ], true);
    return $result;
}

function toggle_like_entry($user_id, $entry_id) {
    $result = safe_query("SELECT id FROM entry_likes WHERE user_id = ? AND entry_id = ? LIMIT 1;", [ $user_id, $entry_id ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);

    if (count($values)) return dislike_entry($user_id, $entry_id);
    return like_entry($user_id, $entry_id);
}

