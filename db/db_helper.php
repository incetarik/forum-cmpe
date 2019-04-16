<?php

/**
 * @param $stmt mysqli_stmt
 * @param $params array
 * @param bool $execute
 * @return bool|mysqli_result
 */
function make_query($stmt, $params, $execute = false) {
    if (!is_array($params)) throw new UnexpectedValueException('$params must be an array');

    if (count($params)) {
        $types = '';

        foreach ($params as $param) {
            if (is_int($param)) $types .= 'i';
            else if (is_double($param) || is_float($param)) $types .= 'd';
            else if (is_string($param)) $types .= 's';
            else $types .= 'b';
        }

        if (!$execute) {
            return $stmt->bind_param($types, $params);
        }
    }
    else if (!$execute) {
        return true;
    }

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();
}

/**
 * @param $sql string SQL Query.
 * @param $paramsOrExecute array|bool|mixed Array of parameters or execute value.
 * @param bool $execute True if the statement should be executed.
 * @return bool|mysqli_result
 */
function safe_query($sql, $paramsOrExecute, $execute = false) {
    $db = get_db();
    $result = $db->prepare($sql);

    if (is_bool($paramsOrExecute)) {
        return make_query($result, [], $paramsOrExecute);
    }
    else if (!is_array($paramsOrExecute)) {
        if ($paramsOrExecute != null) {
            $paramsOrExecute = [$paramsOrExecute];
        }
        else throw new UnexpectedValueException('$paramsOrExecute must be an array');
    }

    return make_query($result, $paramsOrExecute, $execute);
}
