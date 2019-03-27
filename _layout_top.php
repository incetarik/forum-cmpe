<?php
require_once 'db.php';
require_once 'commons.php';

try_init_tables();

?>

<html lang="en">
<head>
    <title><?= $title or 'Forum' ?></title>
</head>
<body>
<?php include_once 'header.php' ?>
