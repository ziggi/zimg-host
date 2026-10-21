<?php

// folder of the running script relative to this file ('' for index.php, '/api' for api/*.php)
$script_dir = realpath(dirname($_SERVER['SCRIPT_FILENAME'] ?? '')) ?: __DIR__;
$script_subdir = str_replace('\\', '/', substr($script_dir, strlen(__DIR__)));

// site path in the url without the script subfolder and trailing slash ('' when installed in the web root)
$base_path = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($script_subdir !== '' && substr($base_path, -strlen($script_subdir)) === $script_subdir) {
	$base_path = substr($base_path, 0, -strlen($script_subdir));
}

return array(
	// version
	'version' => ($version = '4.0.0'),
	// upload password
	'password' => '',
	// description
	'description' => ($description = 'Simple image hosting service'),
	// keywords
	'keywords' => 'image host, zimg-host',
	// title
	'title' => 'zimg-host v' . $version . ' - ' . $description,
	// template folder name under /tpl
	'tpl' => ($tpl = 'material'),
	// template folder path
	'tpl_path' => dirname(__FILE__) . '/tpl/' . $tpl . '/',
	// uri addres to site
	'uri' => '//' . ($_SERVER['SERVER_NAME'] ?? '') . $base_path,
	// params
	'uri_param' => (string)preg_replace('#^' . preg_quote($base_path, '#') . '/?#', '', $_SERVER['REQUEST_URI'] ?? '', 1),
);
