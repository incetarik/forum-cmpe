<?php

require_once __DIR__ . '/db_helper.php';

function get_sidebar_contents() {
    $sql = <<<SQL
    SELECT sidebar_contents.*, u.name, u.surname
    FROM sidebar_contents
    LEFT JOIN users u on sidebar_contents.added_by = u.id;
SQL;

    $result = safe_query($sql, true);
    $values = $result->fetch_all(MYSQLI_BOTH);
    return $values;
}

function create_sidebar_content($added_by, $title, $content) {
    $sql = <<<SQL
    INSERT INTO sidebar_contents (title, content, added_by)
    VALUES (?, ?, ?);
SQL;

    list($result, $stmt) = safe_query($sql, [ $title, $content, $added_by ], true, true);
    return $stmt->affected_rows;
}

function delete_sidebar_content($id) {
    list ($result, $stmt) = safe_query("DELETE FROM sidebar_contents WHERE id = ?", [ $id ], true, true);
    return $stmt->affected_rows;
}
