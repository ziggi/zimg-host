<?php

session_start();

include 'include/upload.class.php';
$conf = include 'config.php';
$tpl = array();

// get config info
$base = Upload::$filename_config['base'];
$length = Upload::$filename_config['length'];

// check file
$file_name = str_replace('thumb/', '', $conf['uri_param'], $count);
$is_thumb = $count == 1;
$is_valid_file = preg_match('/^[' . $base . ']{' . $length . '}\.[a-z]+$/', $file_name) == 1;

if (!$is_valid_file) {
	if (!empty($conf['password'])) {
		// check password
		if (!isset($_SESSION['password_accepted'])) {
			if (isset($_GET['badpassword'])) {
				$tpl['message'] = 'Password is incorrect';
			}
			$tpl['content'] = get_include_contents($conf['tpl_path'] . 'password.php');
			return;
		}
	} else {
		$tpl['content'] = get_include_contents($conf['tpl_path'] . 'upload.php');
		return;
	}
}

// check uri
if (empty($conf['uri_param'])) {
	$tpl['content'] = get_include_contents($conf['tpl_path'] . 'upload.php');
	return;
}

if ($is_thumb) {
	$file_path = 'file/thumb/' . $file_name[0] . '/' . $file_name[1] . '/' . $file_name;
} else {
	$file_path = 'file/' . $file_name[0] . '/' . $file_name[1] . '/' . $file_name;
}

if (file_exists($file_path)) {
	$img_info = getimagesize($file_path);
	header('Content-type: ' . $img_info['mime']);
	readfile($file_path);
} else {
	header('HTTP/1.0 404 Not Found');
	echo 'Error 404: Not Found';
}

exit;
