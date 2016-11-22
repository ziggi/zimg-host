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
        <form method="post" enctype="multipart/form-data" action="<?=$conf['uri']?>/api/unlock.php">
        <?php
          if (isset($tpl['message'])) {
            echo '<p>' . $tpl['message'] . '</p>';
          }
        ?>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="password" id="password" name="password">
            <label class="mdl-textfield__label" for="password">Password...</label>
          </div>
          <button class="mdl-button mdl-js-button mdl-button--raised" id="btn-unlock">
            <i class="material-icons">lock_outline</i>Get access
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
