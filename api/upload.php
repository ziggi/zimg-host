<?php

include '../include/upload.class.php';

// access for remote uploads
header('Access-Control-Allow-Origin: *');

// upload files
$upload = new Upload();

if (isset($_POST['urls'])) {
	if (is_array($_POST['urls'])) {
		$upload->upload_urls($_POST['urls']);
	}
} else if (isset($_FILES['files'])) {
	if (is_array($_FILES['files'])) {
		$upload->upload_files($_FILES['files']);
	}
}
