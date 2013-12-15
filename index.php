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

<div id="overlay"></div>

<div id="info">
  <span>zimg-host v<?php echo $site['version']; ?></span>
  <span><a href="https://github.com/ziggi/zimg-host" target="_blank">GitHub</a></span>
  <span><a href="http://ziggi.org/" target="_blank">Home</a></span>
</div>

<div id="middle">
  <div id="content">
    <ul class="btn-list">
      <li>
        <button class="btn pull-left" id="btn-disc">Upload from disc</button>
        <form id="form-input" method="post" enctype="multipart/form-data" action="upload.php">
          <input type="file" name="files[]" id="file-input" multiple>
        </form>
      </li>
      <li>
        <button class="btn pull-right" id="btn-url">Upload from URL</button>
      </li>
    </ul>
    <div class="progress">
      <div class="file-progress">
        <div class="file-progress-bar"></div>
        <div class="file-progress-percent">0%</div>
      </div>
    </div>
    <div id="file-list">
    </div>
  </div>
  <div id="bottom">
  </div>
</div>

<div id="url-menu">
  <h2>Paste URL's here</h2>
  <textarea></textarea>
  <button class="btn pull-left" id="btn-url-clear">Clear</button>
  <button class="btn pull-right" id="btn-url-upload">Upload</button>
  <button class="btn pull-right" id="btn-url-close">Close</button>
</div>

<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/jquery.form.min.js'></script>
<script type='text/javascript' src='js/scripts.js'></script>

</body>

</html>
