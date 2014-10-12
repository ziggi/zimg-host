<?php

$conf = include 'config.php';

$name = htmlentities($_GET['name']);
$error = htmlentities($_GET['error']);

include sprintf('tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));