<?php

$conf = include '../config.php';

$url = htmlentities((string)($_POST['url'] ?? ''), ENT_QUOTES, 'UTF-8');
$thumburl = htmlentities((string)($_POST['thumbUrl'] ?? ''), ENT_QUOTES, 'UTF-8');
$name = htmlentities((string)($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$width = htmlentities((string)($_POST['size']['width'] ?? ''), ENT_QUOTES, 'UTF-8');
$height = htmlentities((string)($_POST['size']['height'] ?? ''), ENT_QUOTES, 'UTF-8');
$filesize = round((float)($_POST['size']['filesize'] ?? 0) / 1024, 2);

include $conf['tpl_path'] . 'file_item.php';
