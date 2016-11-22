<?php

$uri_parts = explode('/', $_SERVER['PHP_SELF']);

return array(
	// version
	'version' => ($version = '3.0.2'),
	// upload password
	'password' => 'test',
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
	'uri' => '//' . preg_replace('#/$#', '', $_SERVER['SERVER_NAME'] . '/' . $uri_parts[1]),
	// params
	'uri_param' => preg_replace('#^' . dirname($_SERVER['PHP_SELF']) . '/?#', '', $_SERVER['REQUEST_URI'], 1),
);
