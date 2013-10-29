<?php

class Upload {
	private $_files;
	private $_files_count;
	private $_allowed_types = array(
			'image/png' => 'png',
			'image/jpeg' => 'jpg',
			'image/jpg' => 'jpg',
			'image/bmp' => 'bmp',
			'image/gif' => 'gif',
		);

	function __construct($files_array) {
		$this->_files_count = count($files_array['name']);
		$this->_files = $this->restruct_input_array($files_array);
	}

	public function upload() {
		$array_result = array();

		for ($i = 0; $i < $this->_files_count; $i++) {
			$array_result[$i]['name'] = $this->_files[$i]['name'];
			$array_result[$i]['size'] = $this->_files[$i]['size'];
			$array_result[$i]['type'] = $this->_files[$i]['type'];
			$array_result[$i]['error']['upload'] = 0;
			$array_result[$i]['error']['type'] = 0;
			$array_result[$i]['error']['size'] = 0;


			if ($this->_files[$i]['error'] === 1) {
				$array_result[$i]['error']['upload'] = 1;
				continue;
			}

			if (!isset($this->_allowed_types[ $this->_files[$i]['type'] ])) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['type'] = 1;
				continue;
			}

			if ($this->_files[$i]['size'] > 999999) {
				$array_result[$i]['error']['upload'] = 1;
				$array_result[$i]['error']['size'] = 1;
				continue;
			}

			$new_name = md5(microtime() . $this->_files[$i]['name'] . $this->_files[$i]['tmp_name'] . rand(0, 9999)) . '.' . $this->_allowed_types[ $this->_files[$i]['type'] ];
			move_uploaded_file($this->_files[$i]['tmp_name'], __DIR__ . '/file/' . $new_name);

			$array_result[$i]['url'] = $new_name;
		}
		echo json_encode($array_result);
		//print_r($array_result);
	}

	public function restruct_input_array($files_array) {
		$result_array = array();
		$file_keys = array_keys($files_array);

		for ($i = 0; $i < $this->_files_count; $i++) {
			foreach ($file_keys as $key) {
				$result_array[$i][$key] = $files_array[$key][$i];
			}
		}

		return $result_array;
	}
}