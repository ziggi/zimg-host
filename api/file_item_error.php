<?php

$conf = include '../config.php';

$name = htmlentities($_POST['name'], null, 'UTF-8');
$error = htmlentities($_POST['error'], null, 'UTF-8');

include $conf['tpl_path']  . 'file_item_error.php';
