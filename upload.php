<?php

include 'upload.class.php';

// access for remote uploads
header('Access-Control-Allow-Origin: *');

// upload files
$upload = new Upload();

if (isset($_GET['urls'])) {
	$upload->upload_urls($_GET['urls']);
} else {
	$upload->upload_files($_FILES['files']);
}