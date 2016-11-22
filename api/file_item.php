<?php

$conf = include '../config.php';

$url = htmlentities($_POST['url'], null, 'UTF-8');
$thumburl = htmlentities($_POST['thumbUrl'], null, 'UTF-8');
$name = htmlentities($_POST['name'], null, 'UTF-8');
$width = htmlentities($_POST['size']['width'], null, 'UTF-8');
$height = htmlentities($_POST['size']['height'], null, 'UTF-8');
$filesize = round($_POST['size']['filesize'] / 1024, 2);

include $conf['tpl_path'] . 'file_item.php';
