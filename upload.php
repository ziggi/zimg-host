<?php

include 'upload.class.php';

// access for remote uploads
header('Access-Control-Allow-Origin: *');

// upload files
$upload = new Upload();

if (isset($_POST['urls'])) {
	$upload->upload_urls($_POST['urls']);
} else {
	$upload->upload_files($_FILES['files']);
}