<?php

$conf = include '../config.php';

$name = htmlentities($_POST['name'], null, 'UTF-8');
$error = htmlentities($_POST['error'], null, 'UTF-8');

include sprintf('../tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));
