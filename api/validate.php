<?php

include '../include/upload.class.php';
include '../include/functions.php';

// access for remote checks
header('Access-Control-Allow-Origin: *');

// check access
if (!isHaveAccess()) {
	exit('no access');
}

// check files
$upload = new Upload();

$array_result = array();

$files = json_decode(stripslashes($_POST['files']), true);

foreach ($files as $file) {
	$array = array();
	$array['name'] = $file['name'];
	
	$array['error']['upload'] = 0;
	$array['error']['type'] = 0;
	$array['error']['size'] = 0;

	if (!$upload->is_support_size($file['size'])) {
		$array['error']['upload'] = 1;
		$array['error']['size'] = 1;
	}

	if (!$upload->is_support_type(mime_type_to_image_type($file['type']))) {
		$array['error']['upload'] = 1;
		$array['error']['type'] = 1;
	}

	$array_result[] = $array;
}

echo json_encode($array_result);

function mime_type_to_image_type($mime_type) {
	switch ($mime_type) {
		case 'image/gif':
			return IMAGETYPE_GIF;
		case 'image/jpeg':
		case 'image/pjpeg':
		case 'image/jpg':
			return IMAGETYPE_JPEG;
		case 'image/png':
			return IMAGETYPE_PNG;
		case 'image/vnd.wap.wbmp':
			return IMAGETYPE_WBMP;
		default:
			return false;
	}
}
