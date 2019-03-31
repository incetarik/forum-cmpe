<?php require_once __DIR__ . '/helpers/commons.php';

unset($_SESSION[SESSION_KEY_USER]);
redirect('/');
