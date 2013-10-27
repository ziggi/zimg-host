<?php

$site['version'] = '2.0';

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="description" content="Simple image hosting service">
  <meta name="keywords" content="image host, zimg-host">
  <meta name="viewport" content="width=device-width">
  <title>zimg-host - Simple image hosting service</title>
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<div id="info">
  <span>zimg-host v<?php echo $site['version']; ?></span>
  <span><a href="https://github.com/ziggi/zimg-host" target="_blank">GitHub</a></span>
  <span><a href="http://ziggi.org/" target="_blank">Home</a></span>
</div>

<div id="middle">
  <div id="content">
    <ul class="btn-list">
      <li><button class="btn pull-left">Upload from disc</button></li>
      <li><button class="btn pull-right">Upload from URL</button></li>
    </ul>
  </div>
</div>

</body>

</html>
