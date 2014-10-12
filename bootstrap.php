<?php

$conf = include 'config.php';

if (empty($conf['uri_param'])) {
	return;
}

$img_file = str_replace('thumb/', '', $conf['uri_param'], $count);

if ($count == 1) {
	$img_file = 'file/thumb/' . $img_file[0] . '/' . $img_file[1] . '/' . $img_file;
} else {
	$img_file = 'file/' . $img_file[0] . '/' . $img_file[1] . '/' . $img_file;
}

if (file_exists($img_file)) {
	$img_info = getimagesize($img_file);

	header('Content-type: ' . $img_info['mime']);

	readfile($img_file);
} else {
	header('HTTP/1.0 404 Not Found');
	echo '404';
	exit;
}