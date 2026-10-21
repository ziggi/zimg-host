<?php

$conf = include '../config.php';

$name = htmlentities((string)($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$error = htmlentities((string)($_POST['error'] ?? ''), ENT_QUOTES, 'UTF-8');

include $conf['tpl_path']  . 'file_item_error.php';
