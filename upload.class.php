<?php

class Upload {
	private $_allowed_types = array(
			IMAGETYPE_GIF  => array('function_postfix' => 'gif',  'file_format' => 'gif'),
			IMAGETYPE_JPEG => array('function_postfix' => 'jpeg', 'file_format' => 'jpg'),
			IMAGETYPE_PNG  => array('function_postfix' => 'png',  'file_format' => 'png'),
			IMAGETYPE_WBMP => array('function_postfix' => 'wbmp', 'file_format' => 'wbmp'),
		);

	private $_blacklisted_domains = array(
			'img.ziggi.org',
		);

	const MAX_FILE_SIZE = '2M';

	public function upload_urls($urls_array) {
		$files_count = count($urls_array);

		$array_result = array();

		for ($i = 0; $i < $files_count; $i++) {
			$is_blacklisted = false;

			// check domain
			foreach ($this->_blacklisted_domains as $domain_name) {
				if (strpos($urls_array[$i], $domain_name) !== false) {
					$is_blacklisted = true;
					$array_result[$i]['error']['host'] = 1;
					break;
				}
			}

			// copy file to temp dir
			$temp_name = tempnam("/tmp", "zmg");
			$is_copied = @copy($urls_array[$i], $temp_name);

			// upload
			$this->upload_handling($array_result[$i], $urls_array[$i], $temp_name, !$is_copied | $is_blacklisted);
		}

		echo json_encode($array_result);
	}

	public function upload_files($files_array) {
		if (!is_array($files_array)) {
			return;
		}

		$files_count = count($files_array['name']);
		$files = $this->restruct_input_array($files_array, $files_count);

		$array_result = array();

		for ($i = 0; $i < $files_count; $i++) {
			$this->upload_handling($array_result[$i], $files[$i]['name'], $files[$i]['tmp_name'], $files[$i]['error']);
		}

		echo json_encode($array_result);
	}

	protected function upload_handling(&$array, $name, $temp_name, $is_error) {
		$array['name'] = $name;

		// get size and type
		list($width, $height, $type) = getimagesize($temp_name);
		$array['type'] = $type;
		$array['size']['width'] = $width;
		$array['size']['height'] = $height;
		$array['size']['filesize'] = filesize($temp_name);

		// error checking
		$array['error']['upload'] = 0;
		$array['error']['type'] = 0;
		$array['error']['size'] = 0;

		if ($is_error === 1) {
			$array['error']['upload'] = 1;
		}

		if (!$this->is_support_type($type)) {
			$array['error']['upload'] = 1;
			$array['error']['type'] = 1;
		}

		if (!$this->is_support_size($array['size']['filesize'])) {
			$array['error']['upload'] = 1;
			$array['error']['size'] = 1;
		}

		if ($array['error']['upload'] == 1) {
			return false;
		}

		// generate new name
		$new_name = null;
		
		do {
			$new_name = md5(microtime() . $name . $temp_name . rand(0, 9999)) . '.' . $this->_allowed_types[$type]['file_format'];
		} while (file_exists(__DIR__ . '/file/' . $new_name));

		// move temp file with new name
		$file_path = __DIR__ . '/file/' . $new_name[0] . '/' . $new_name[1] . '/';
		if (!file_exists($file_path)) {
			mkdir($file_path, 0777, true);
		}
		copy($temp_name, $file_path . $new_name);
		unlink($temp_name);

		// make thumbnail image
		$thumb_path = __DIR__ . '/file/thumb/' . $new_name[0] . '/' . $new_name[1] . '/';
		if (!file_exists($thumb_path)) {
			mkdir($thumb_path, 0777, true);
		}
		$this->create_thumbnail_image($file_path . $new_name, $thumb_path . $new_name, 420);

		// save new name for response
		$array['url'] = $new_name;

		return true;
	}

	private function restruct_input_array($files_array, $files_count) {
		$result_array = array();
		$file_keys = array_keys($files_array);

		if (!is_array($files_array[ $file_keys[0] ])) {
			$result_array[0] = $files_array;
		} else {
			for ($i = 0; $i < $files_count; $i++) {
				foreach ($file_keys as $key) {
					$result_array[$i][$key] = $files_array[$key][$i];
				}
			}
		}

		return $result_array;
	}

	private function is_support_size($size) {
		$is_app_support_size = $size <= $this->return_bytes(self::MAX_FILE_SIZE);
		$is_php_support_size = $size <= $this->return_bytes(ini_get('upload_max_filesize'));
		$is_post_support_size = $size <= $this->return_bytes(ini_get('post_max_size'));

		if ($size === false || !$is_app_support_size || !$is_php_support_size || !$is_post_support_size) {
			return false;
		}

		return true;
	}

	private function is_support_type($type) {
		if (!isset($this->_allowed_types[$type])) {
			return false;
		}
		return true;
	}

	private function create_thumbnail_image($src_path, $dest_path, $new_width) {
		list($width, $height, $type) = getimagesize($src_path);

		if ($new_width > $width) {
			copy($src_path, $dest_path);
			return;
		}

		$new_height = round($new_width * $height / $width);

		$create_function = "imagecreatefrom" . $this->_allowed_types[$type]['function_postfix'];
		$src_res = @$create_function($src_path);
		if ($src_res === false) {
			return;
		}

		$dest_res = imagecreatetruecolor($new_width, $new_height);

		imagecopyresampled($dest_res, $src_res, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		
		$create_function = "image" . $this->_allowed_types[$type]['function_postfix'];
		$create_function($dest_res, $dest_path);
		
		imagedestroy($dest_res);
		imagedestroy($src_res);
	}

	private function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[ strlen($val) - 1 ]);

		switch ($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}
}
