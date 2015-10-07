<div class="mdl-cell mdl-cell--4-col">
  <div class="image-card mdl-card mdl-shadow--4dp">
    <div class="mdl-card__media">
      <a href="<?=$url?>" target="_blank">
        <img title='Width: <?=$width?>px&#10;Height: <?=$height?>px&#10;Filesize: <?=$filesize?> KiB' src="<?=$thumburl?>">
      </a>
    </div>
    <div class="mdl-card__supporting-text">
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" onclick="select()" readonly value="<?=$url?>" />
      </div>
    </div>
  </div>
</div>