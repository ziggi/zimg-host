<?php

include 'upload.class.php';

$files_array = $_FILES['files'];

// access for remote uploads
header('Access-Control-Allow-Origin: *');

// upload files
$upload = new Upload($files_array);
$upload->upload();

