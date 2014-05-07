<?php

class Upload {
	private $_allowed_types = array(
			IMAGETYPE_GIF  => array('function_postfix' => 'gif',  'file_format' => 'gif'),
			IMAGETYPE_JPEG => array('function_postfix' => 'jpeg', 'file_format' => 'jpg'),
			IMAGETYPE_PNG  => array('function_postfix' => 'png',  'file_format' => 'png'),
			IMAGETYPE_BMP  => array('function_postfix' => 'wbmp', 'file_format' => 'bmp'),
		);

	public function upload_urls($urls_array) {
		$files_count = count($urls_array);

		$array_result = array();

		for ($i = 0; $i < $files_count; $i++) {
			$array_result[$i]['name'] = $urls_array[$i];
			$array_result[$i]['error']['upload'] = 0;
			$array_result[$i]['error']['type'] = 0;
			$array_result[$i]['error']['size'] = 0;


			$temp_name = tempnam("/tmp", "zmg");
			$is_copied = copy($urls_array[$i], $temp_name);

			if (!$is_copied) {
				$array_result[$i]['error']['upload'] = 1;
			}


			list($width, $height, $type) = getimagesize($temp_name);
			$array_result[$i]['type'] = $type;
			$array_result[$i]['size']['width'] = $width;
			$array_result[$i]['size']['height'] = $height;

			if (!$this->is_support_type($array_result[$i]['type'])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['type'] = 1;
			}


			$array_result[$i]['size']['filesize'] = filesize($temp_name);

			if (!$this->is_support_size($array_result[$i]['size']['filesize'])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['size'] = 1;
			}

			if ($array_result[$i]['error']['upload'] == 1) {
				continue;
			}

			$new_name = md5(microtime() . $urls_array[$i] . rand(0, 9999)) . '.' . $this->_allowed_types[ $array_result[$i]['type'] ]['file_format'];
			copy($temp_name, __DIR__ . '/file/' . $new_name);
			unlink($temp_name);

			$this->image_resize(__DIR__ . '/file/' . $new_name, __DIR__ . '/file/thumbnail/' . $new_name, 420);

			$array_result[$i]['url'] = $new_name;
		}
		echo json_encode($array_result);
	}

	public function upload_files($files_array) {
		$files_count = count($files_array['name']);
		$files = $this->restruct_input_array($files_array, $files_count);

		$array_result = array();

		for ($i = 0; $i < $files_count; $i++) {
			$array_result[$i]['name'] = $files[$i]['name'];

			list($width, $height, $type) = getimagesize($files[$i]['tmp_name']);
			$array_result[$i]['type'] = $type;
			$array_result[$i]['size']['width'] = $width;
			$array_result[$i]['size']['height'] = $height;
			$array_result[$i]['size']['filesize'] = $files[$i]['size'];

			$array_result[$i]['error']['upload'] = 0;
			$array_result[$i]['error']['type'] = 0;
			$array_result[$i]['error']['size'] = 0;

			if ($files[$i]['error'] === 1) {
				$array_result[$i]['error']['upload'] = 1;
			}

			if (!$this->is_support_type($type)) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['type'] = 1;
			}

			if (!$this->is_support_size($files[$i]['size'])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['size'] = 1;
			}

			if ($array_result[$i]['error']['upload'] == 1) {
				continue;
			}

			$new_name = md5(microtime() . $files[$i]['name'] . $files[$i]['tmp_name'] . rand(0, 9999)) . '.' . $this->_allowed_types[$type]['file_format'];
			move_uploaded_file($files[$i]['tmp_name'], __DIR__ . '/file/' . $new_name);

			$this->image_resize(__DIR__ . '/file/' . $new_name, __DIR__ . '/file/thumbnail/' . $new_name, 420);

			$array_result[$i]['url'] = $new_name;
		}
		echo json_encode($array_result);
	}

	public function restruct_input_array($files_array, $files_count) {
		$result_array = array();
		$file_keys = array_keys($files_array);

		for ($i = 0; $i < $files_count; $i++) {
			foreach ($file_keys as $key) {
				$result_array[$i][$key] = $files_array[$key][$i];
			}
		}

		return $result_array;
	}

	public function is_support_size($size) {
		if ($size === false || $size > 2 * 1024 * 1024) {
			return false;
		}
		return true;
	}

	public function is_support_type($type) {
		if (!isset($this->_allowed_types[$type])) {
			return false;
		}
		return true;
	}

	public function image_resize($src_path, $dest_path, $newwidth) {
		list($width, $height, $type) = getimagesize($src_path);

		if ($newwidth > $width) {
			copy($src_path, $dest_path);
			return;
		}

		$newheight = round($newwidth * $height / $width);

		$create_function = "imagecreatefrom" . $this->_allowed_types[$type]['function_postfix'];
		$src_res = $create_function($src_path);

		$dest_res = imagecreatetruecolor($newwidth, $newheight);

		imagecopyresampled($dest_res, $src_res, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		
		$create_function = "image" . $this->_allowed_types[$type]['function_postfix'];
		$create_function($dest_res, $dest_path);
		
		imagedestroy($dest_res);
		imagedestroy($src_res);
	}
}
