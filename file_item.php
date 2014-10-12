<?php

$conf = include 'config.php';

$url = htmlentities($_GET['url']);
$thumburl = htmlentities($_GET['thumbUrl']);
$name = htmlentities($_GET['name']);
$width = htmlentities($_GET['size']['width']);
$height = htmlentities($_GET['size']['height']);
$filesize = round($_GET['size']['filesize'] / 1024, 2);

include sprintf('tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));