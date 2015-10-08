<?php

return array(
	// version
	'version' => ($version = '3.0.0'),
	// description
	'description' => 'Simple image hosting service',
	// keywords
	'keywords' => 'image host, zimg-host',
	// title
	'title' => 'zimg-host v' . $version . ' - Simple image hosting service',
	// template folder name under /tpl
	'tpl' => 'material',
	// uri addres to site
	'uri' => '//' . preg_replace('#/$#', '', $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])),
	// params
	'uri_param' => preg_replace('#^' . dirname($_SERVER['PHP_SELF']) . '/?#', '', $_SERVER['REQUEST_URI'], 1),
);
