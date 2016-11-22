<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="<?=$conf['description']?>">
    <meta name="keywords" content="<?=$conf['keywords']?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$conf['title']?></title>
    <link rel="shortcut icon" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/img/favicon.ico" />
    <link href='//fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/css/material.min.css">
    <link rel="stylesheet" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/css/styles.css">
  </head>
  <body class="mdl-color--grey-100">
    <div class="mdl-progress mdl-js-progress" id="progress"></div>
    <div class="mdl-layout mdl-js-layout">
      <main class="mdl-layout__content">
        <?=$tpl['content']?>
      </main>
    </div>
    <script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/js/material.min.js"></script>
    <script src="<?=$conf['uri']?>/js/scripts.js"></script>
    <script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/js/scripts.js"></script>
  </body>
</html>
