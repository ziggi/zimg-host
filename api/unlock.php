<?php

include '../include/functions.php';

$conf = include '../config.php';
$tpl = array();

$password = htmlentities($_POST['password'], null, 'UTF-8');

if ($password !== $conf['password']) {
	header('Location: ' . $conf['uri'] . '?badpassword');
} else {
	session_start();
	$_SESSION['password_accepted'] = true;
	header('Location: ' . $conf['uri']);
}
