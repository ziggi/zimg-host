<?php

$conf = include 'config.php';

$url = htmlentities($_POST['url']);
$thumburl = htmlentities($_POST['thumbUrl']);
$name = htmlentities($_POST['name']);
$width = htmlentities($_POST['size']['width']);
$height = htmlentities($_POST['size']['height']);
$filesize = round($_POST['size']['filesize'] / 1024, 2);

include sprintf('tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));