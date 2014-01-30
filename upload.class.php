<?php

class Upload {
	private $_allowed_types = array(
			'image/png' => 'png',
			'image/jpeg' => 'jpg',
			'image/jpg' => 'jpg',
			'image/bmp' => 'bmp',
			'image/gif' => 'gif',
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


			$img_size = getimagesize($temp_name);
			$array_result[$i]['type'] = $img_size['mime'];

			if (!$this->is_support_type($array_result[$i]['type'])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['type'] = 1;
			}


			$array_result[$i]['size'] = filesize($temp_name);

			if (!$this->is_support_size($array_result[$i]['size'])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['size'] = 1;
			}

			if ($array_result[$i]['error']['upload'] == 1) {
				continue;
			}

			$new_name = md5(microtime() . $urls_array[$i] . rand(0, 9999)) . '.' . $this->_allowed_types[ $array_result[$i]['type'] ];
			copy($temp_name, __DIR__ . '/file/' . $new_name);
			unlink($temp_name);

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
			$array_result[$i]['size'] = $files[$i]['size'];
			$array_result[$i]['type'] = $files[$i]['type'];
			$array_result[$i]['error']['upload'] = 0;
			$array_result[$i]['error']['type'] = 0;
			$array_result[$i]['error']['size'] = 0;

			if ($files[$i]['error'] === 1) {
				$array_result[$i]['error']['upload'] = 1;
			}

			if (!$this->is_support_type($files[$i]['type'])) {
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

			$new_name = md5(microtime() . $files[$i]['name'] . $files[$i]['tmp_name'] . rand(0, 9999)) . '.' . $this->_allowed_types[ $files[$i]['type'] ];
			move_uploaded_file($files[$i]['tmp_name'], __DIR__ . '/file/' . $new_name);

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
}