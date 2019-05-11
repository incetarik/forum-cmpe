<?php

require_once dirname(__DIR__) . '/helpers/commons.php';
require_once dirname(__DIR__) . '/helpers/db.php';

$API_FUNCTIONS = [];

function register_handler($name, $handler_function, $type = 'gp') {
    global $API_FUNCTIONS;
    $API_FUNCTIONS = array_merge($API_FUNCTIONS, [$name => [$handler_function, $type]]);
}

function handle_request() {
    global $API_FUNCTIONS;
    $value = false;
    if (array_key_exists('f', $_GET)) {
        $func = $_GET['f'];
        if (array_key_exists($func, $API_FUNCTIONS)) {
            $value = $API_FUNCTIONS[$func];
        }
    }

    header('Content-Type: application/json; charset=UTF-8', true);

    if (!$value) {
        echo json_encode([
            'success' => false,
            'error' => [
                'code' => -1,
                'message' => 'UNAUTHORIZED',
                'location' => __FILE__ . ', Line: ' . __LINE__
            ]
        ]);
        die;
    }

    $handler_func_name = $value[0];
    $accept_type = $value[1];

    $params = [];
    if (strpos($accept_type, 'g') !== false) {
        $params = array_merge($params, $_GET);
    }

    if (strpos($accept_type, 'p') !== false) {
        $params = array_merge($params, $_POST);
    }

    try {
        $result = call_user_func($handler_func_name, $params);
        echo json_encode([
            'success' => true,
            'data' => $result
        ]);
    }
    catch (Throwable $e) {
        error_log($e->getMessage());
        echo json_encode([
            'success' => false,
            'error' => [
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
                'location' => $e->getFile() . ', Line: ' . $e->getLine()
            ]
        ]);
    }
}









