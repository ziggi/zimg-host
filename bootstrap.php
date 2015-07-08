<?php

$conf = include 'config.php';

if (empty($conf['uri_param'])) {
	return;
}

$file_name = str_replace('thumb/', '', $conf['uri_param'], $count);

if ($count == 1) {
	$file_path = 'file/thumb/' . $file_name[0] . '/' . $file_name[1] . '/' . $file_name;
} else {
	$file_path = 'file/' . $file_name[0] . '/' . $file_name[1] . '/' . $file_name;
}

include 'upload.class.php';
$base = Upload::$filename_config['base'];
$length = Upload::$filename_config['length'];

$is_valid_file = preg_match('/^[' . $base . ']{' . $length . '}\.[a-z]+$/', $file_name) == 1;

if ($is_valid_file && file_exists($file_path)) {
	$img_info = getimagesize($file_path);

	header('Content-type: ' . $img_info['mime']);

	readfile($file_path);
} else {
	header('HTTP/1.0 404 Not Found');
	echo '404';
	exit;
}