<?php

$conf = include '../config.php';

$name = htmlentities($_POST['name']);
$error = htmlentities($_POST['error']);

include sprintf('../tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));