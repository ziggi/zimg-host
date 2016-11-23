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

<?=$tpl['content']?>

<script src="<?=$conf['uri']?>/js/scripts.js"></script>
<script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/js/scripts.js"></script>

</body>

</html>
