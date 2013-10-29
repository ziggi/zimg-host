<?php

include 'upload.class.php';

$files_array = $_FILES['files'];

$upload = new Upload($files_array);
$upload->upload();

