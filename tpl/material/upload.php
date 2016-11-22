<div class="mdl-grid" id="main-grid">
  <div class="mdl-cell mdl-cell--4-col">
    <div class="info-card mdl-card mdl-shadow--4dp">
      <div class="mdl-card__title">
        <h2 class="mdl-card__title-text">zimg-host v<?=$conf['version']?></h2>
        <div id="credits">
          <a href="https://github.com/ziggi/zimg-host" target="_blank">GitHub</a>
          <a href="https://ziggi.org/" target="_blank">Home</a>
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
          <i class="material-icons">file_upload</i>file
        </button>
      </div>
    </div>
  </div>
</div>
