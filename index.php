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
      <li>
        <button class="btn pull-left" id="btn-disc">Upload from disc</button>
        <form id="form-input" method="post" enctype="multipart/form-data" action="upload.php">
          <input type="file" name="files[]" id="file-input" multiple>
        </form>
      </li>
      <li><button class="btn pull-right" id="btn-url">Upload from URL</button></li>
    </ul>
    <div id="file-list">
      <div class="file-item">
        <p><a href="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png" target="_blank"><img src="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></a></p>
        <table>
          <tbody>
            <tr><td>Изображение</td><td><input type="text" value="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></td></tr>
            <tr><td>Превью с увеличением, BB код</td><td><input type="text" value="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></td></tr>
            <tr><td>Картинка, BB код</td><td><input type="text" value="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></td></tr>
            <tr><td>Превью с увеличением, HTML код</td><td><input type="text" value="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></td></tr>
            <tr><td>Картинка, HTML код</td><td><input type="text" value="http://127.0.0.1/img.ziggi.org/file/7af7ebdcc5620775c663e1e3a0d8df51.png"></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type='text/javascript' src='js/jquery-2.0.3.min.js'></script>
<script type='text/javascript' src='js/jquery.form.min.js'></script>
<script type='text/javascript' src='js/scripts.js'></script>

</body>

</html>
