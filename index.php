<?php

include 'bootstrap.php';

include sprintf('tpl/%s/%s.php', $conf['tpl'], pathinfo(__FILE__, PATHINFO_FILENAME));