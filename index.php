<?php
include 'bootstrap.php';

include sprintf('tpl/%s/%s.html', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));