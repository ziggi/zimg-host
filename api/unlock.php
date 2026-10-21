<?php

include '../include/functions.php';
$conf = include '../config.php';

if (!isHaveAccess()) {
	header('Location: ' . $conf['uri'] . '?badpassword');
} else {
	$_SESSION['password_accepted'] = true;
	header('Location: ' . $conf['uri']);
}
