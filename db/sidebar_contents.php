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

