<?php

return array(
	// template folder name under /tpl
	'tpl' => 'default',
	// uri addres to site
	'uri' => '//' . $_SERVER['HTTP_HOST'] . str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname(__FILE__)),
	// params
	'uri_param' => preg_replace('#^' . dirname($_SERVER['PHP_SELF']) . '[/]?#', '', $_SERVER['REQUEST_URI'], 1),
);
