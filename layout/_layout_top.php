<?php
require_once dirname(__DIR__) . '/helpers/db.php';
require_once dirname(__DIR__) . '/helpers/commons.php';

try_init_tables();
$has_header = !isset($skip_header) or !$skip_header;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?= (isset($title) ? $title : 'Forum') ?></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../assets/scss/style.css"/>
  <script src="/assets/js/global.js" type="application/javascript"></script>
  <?php if ($has_header): ?>
  <script src="/assets/js/header.js" type="application/javascript"></script>
  <?php endif ?>
</head>
<body>

<?php if ($has_header) {
  include_once dirname(__DIR__) . '/header.php';
} ?>
