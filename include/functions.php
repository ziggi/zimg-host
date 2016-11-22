<?php

function get_include_contents($filename) {
	global $conf, $tpl;
	if (is_file($filename)) {
		ob_start();
		include $filename;
		return ob_get_clean();
	}
	return false;
}
