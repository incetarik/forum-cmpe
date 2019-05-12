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
    list($result, $stmt) = safe_query("INSERT INTO entry_likes (user_id, entry_id) VALUES (?, ?);", [ $user_id, $entry_id ], true, true);
    if ($stmt->affected_rows) return 'like';
    return false;
}

function dislike_entry($user_id, $entry_id) {
    list($result, $stmt) = safe_query("DELETE FROM entry_likes WHERE user_id = ? AND entry_id = ?;", [ $user_id, $entry_id ], true, true);
    if ($stmt->affected_rows) return 'dislike';
    return false;
}

function toggle_like_entry($user_id, $entry_id) {
    $result = safe_query("SELECT id FROM entry_likes WHERE user_id = ? AND entry_id = ? LIMIT 1;", [ $user_id, $entry_id ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);

    if (count($values)) return dislike_entry($user_id, $entry_id);
    return like_entry($user_id, $entry_id);
}

function get_categories() {
    $result = safe_query("SELECT categories FROM entries;", true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    $categories = [];
    foreach ($values as $value) {
        $category_list = explode(';', $value["categories"]);
        foreach ($category_list as $category) {
            $category = trim($category);
            if (in_array($category, $categories)) continue;
            array_push($categories, $category);
        }
    }

    return $categories;
}

function get_entries_by_category($category) {
    if (!$category) return [];
    $result = safe_query("SELECT * FROM entries WHERE categories LIKE ?;", [ "%$category%" ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    return $values;
}

function get_entry_by_id($id) {
    $sql = <<<SQL
    SELECT entries.*, u.name, u.surname, u.email_address, u.job_title
    FROM entries
    LEFT JOIN users u on entries.created_by = u.id
    WHERE entries.id = ?
SQL;

    $result = safe_query($sql, [ $id ], true);
    $values = $result->fetch_assoc();
    return $values;
}


function get_entries_sent_by_user($id) {
    $sql = <<<SQL
    SELECT entries.*, u.name, u.surname, u.email_address, u.job_title
    FROM entries
    LEFT JOIN users u on entries.created_by = u.id
    WHERE u.id = ?
SQL;

    $result = safe_query($sql, [ $id ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    return $values;
}

function get_entries_by_tag($tag) {
    if (!$tag) return [];
    $sql = <<<SQL
    SELECT entries.*, u.name, u.surname, u.email_address, u.job_title
    FROM entries
    LEFT JOIN users u on entries.created_by = u.id
    WHERE entries.tags LIKE ?;
SQL;

    $result = safe_query($sql, [ "%$tag%" ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    return $values;
}

function create_entry($user_id, $title, $content, $categories, $tags) {
    $sql = <<<SQL
    INSERT INTO entries 
        (title, categories, tags, content, created_at, created_by) 
    VALUES (?, ?, ?, ?, ?, ?);
SQL;

    $result = safe_query($sql, [ $title, $categories, $tags, $content, time(), $user_id ], true);
    if (is_bool($result)) return $result;
    return $result->fetch_assoc();
}

function get_has_user_liked_entry($user_id, $entry_id) {
    $sql = "SELECT 1 FROM entry_likes WHERE entry_id = ? AND user_id = ?;";
    $result = safe_query($sql, [ $entry_id, $user_id ], true);
    return $result->num_rows;
}

function get_comments_of_entry($entry_id) {
    $sql = <<<SQL
    SELECT entry_comments.*, u.id as userid, u.name, u.surname, u.email_address, u.job_title
    FROM entry_comments
    LEFT JOIN users u on entry_comments.sent_by = u.id
    WHERE entry_id = ?
    ORDER BY entry_comments.created_at ASC;
SQL;

    $result = safe_query($sql, [ $entry_id ], true);
    return $result->fetch_all(MYSQLI_BOTH);
}

function get_comments_of_entry_by_user($user_id, $entry_id) {
    $sql = <<<SQL
    SELECT entry_comments.*, u.id as userid, u.name, u.surname, u.email_address, u.job_title
    FROM entry_comments
    LEFT JOIN users u on entry_comments.sent_by = u.id
    WHERE entry_id = ? AND sent_by = ?
    ORDER BY entry_comments.created_at ASC;
SQL;

    $result = safe_query($sql, [ $entry_id, $user_id ], true);
    return $result->fetch_all(MYSQLI_BOTH);
}

function add_comment_to_entry($user_id, $entry_id, $title, $content) {
    $sql = <<<SQL
    INSERT INTO entry_comments
    (content, created_at, entry_id, sent_by, title) 
    VALUES 
    (?, ?, ?, ?, ?);
SQL;

    list($result, $stmt) = safe_query($sql, [ $content, time(), $entry_id, $user_id, $title ], true, true);
    return $stmt->affected_rows;
}

function search_in_entries($text) {
    $sql = <<<SQL
    SELECT entries.*, u.job_title, u.name, u.surname, u.email_address
    FROM entries
    LEFT JOIN users u on entries.created_by = u.id
    WHERE 
          title LIKE ? 
       OR content LIKE ?
       OR tags LIKE ?
       OR categories LIKE ?
SQL;

    $result = safe_query($sql, [ "%$text%", "%$text%", "%$text%", "%$text%" ], true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    return $values;
}
