<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="description" content="<?=$conf['description']?>">
  <meta name="keywords" content="<?=$conf['keywords']?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$conf['title']?></title>
  <link rel="shortcut icon" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/img/favicon.ico" />
  <link rel="stylesheet" type="text/css" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/css/style.css">
</head>

<body>

<div id="overlay"></div>

<div id="info">
  <span>zimg-host v<?=$conf['version']?></span>
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
    <div id="get-all-link">
      <span id="btn-links">Get all links</span>
    </div>
    <div id="file-list">
    </div>
  </div>
  <div id="bottom">
  </div>
</div>

<div id="url-menu" class="popup">
  <h2>Paste URL's here</h2>
  <textarea id="url-input"></textarea>
  <button class="btn pull-left" id="btn-url-clear">Clear</button>
  <button class="btn pull-right" id="btn-url-upload">Upload</button>
  <button class="btn pull-right" id="btn-url-close">Close</button>
</div>

<div id="links-menu" class="popup">
  <h2>All links</h2>
  <select>
    <option data-target="link">Link</option>
    <option data-target="bb_pwi">Preview with increasing [BB]</option>
    <option data-target="bb_image">Image [BB]</option>
    <option data-target="html_pwi">Preview with increasing [HTML]</option>
    <option data-target="html_image">Image [HTML]</option>
  </select>
  <textarea id="links-input" readonly onclick="select()"></textarea>
  <button class="btn pull-right" id="btn-links-close">Close</button>
</div>

<script src="<?=$conf['uri']?>/js/scripts.js"></script>
<script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/js/scripts.js"></script>

</body>

</html>
