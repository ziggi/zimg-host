<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Simple image hosting service">
    <meta name="keywords" content="image host, zimg-host">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>zimg-host - Simple image hosting service</title>
    <link rel="shortcut icon" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/img/favicon.png" />
    <link href='//fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/material.min.css">
    <link rel="stylesheet" href="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/styles.css">
  </head>
  <body class="mdl-color--grey-100">
    <div class="mdl-progress mdl-js-progress" id="progress"></div>
    <div class="mdl-layout mdl-js-layout">
      <main class="mdl-layout__content">
        <div class="mdl-grid" id="main-grid">
          <div class="mdl-cell mdl-cell--4-col">
            <div class="info-card mdl-card mdl-shadow--4dp">
              <div class="mdl-card__title">
                <h2 class="mdl-card__title-text">zimg-host v<?=$conf['version']?></h2>
                <div id="credits">
                  <a href="https://github.com/ziggi/zimg-host" target="_blank">GitHub</a>
                  <a href="http://ziggi.org/" target="_blank">Home</a>
                </div>
              </div>
              <div class="mdl-card__supporting-text">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <textarea class="mdl-textfield__input" type="text" rows="8" id="url-input" ></textarea>
                  <label class="mdl-textfield__label" for="url-input">Paste URL's here</label>
                </div>
                <button class="mdl-button mdl-js-button mdl-button--raised" id="btn-url-upload">
                  <i class="material-icons">file_upload</i>URL
                </button>
                <form id="form-input" method="post" enctype="multipart/form-data" action="upload.php">
                  <input type="file" name="files[]" id="file-input" multiple>
                </form>
                <button class="mdl-button mdl-js-button mdl-button--raised" id="btn-disc">
                  <i class="material-icons">file_upload</i>disc
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/material.min.js"></script>
    <script src="<?=$conf['uri']?>/js/scripts.js"></script>
    <script src="<?=$conf['uri']?>/tpl/<?=$conf['tpl']?>/scripts.js"></script>
  </body>
</html>