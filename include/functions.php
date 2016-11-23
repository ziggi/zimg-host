<?php

function get_include_contents($filename) {
	global $conf, $tpl;
	if (is_file($filename)) {
		ob_start();
		include $filename;
		return ob_get_clean();
	}
	return false;
}

function isHaveAccess()
{
	session_start();
	if (isset($_SESSION['password_accepted'])) {
		return true;
	}

	global $conf;
	if (empty($conf['password'])) {
		return true;
	}

	if (isset($_POST['password'])) {
		$password = htmlentities($_POST['password'], null, 'UTF-8');
		return $password === $conf['password'];
	}

	if (isset($_SERVER['PHP_AUTH_PW'])) {
		$password = htmlentities($_SERVER['PHP_AUTH_PW'], null, 'UTF-8');
		return $password === $conf['password'];
	}
	return false;
}
