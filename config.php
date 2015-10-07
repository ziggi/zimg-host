<?php

return array(
	// version
	'version' => '2.1.4',
	// template folder name under /tpl
	'tpl' => 'material',
	// uri addres to site
	'uri' => '//' . preg_replace('#/$#', '', $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF'])),
	// params
	'uri_param' => preg_replace('#^' . dirname($_SERVER['PHP_SELF']) . '/?#', '', $_SERVER['REQUEST_URI'], 1),
);
