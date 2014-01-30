<?php
$url = $_GET['url'];
$name = $_GET['name'];
?>
<div class="file-item">
  <p><a class="direct_link" href="<?=$url?>" target="_blank"><img class="img_small" src="<?=$url?>"></a></p>
  <div class="file-links">
    <div class="row">
      <div class="pull-left">
        <h2>Link</h2>
        <div>
          <input type="text" class="link" onclick="select()" readonly value="<?=$url?>">
        </div>
      </div>
      <div class="pull-right">
        <h2>Direct link</h2>
        <div>
          <input type="text" class="direct_link" onclick="select()" readonly value="<?=$url?>">
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="row">
      <div class="pull-left">
        <h2>Preview with increasing [BB]</h2>
        <div>
          <input type="text" class="bb_pwi" onclick="select()" readonly value="[url=<?=$url?>][img]<?=$url?>[/img][/url]">
        </div>
      </div>
      <div class="pull-right">
        <h2>Image [BB]</h2>
        <div>
          <input type="text" class="bb_image" onclick="select()" readonly value="[img]<?=$url?>[/img]">
        </div>
      </div>
      <div class="clear"></div>
    </div>
    <div class="row">
      <div class="pull-left">
        <h2>Preview with increasing [HTML]</h2>
        <div>
          <input type="text" class="html_pwi" onclick="select()" readonly value='<a href="<?=$url?>" target="_blank"><img src="<?=$url?>" attr="<?=$name?>"></a>'>
        </div>
      </div>
      <div class="pull-right">
        <h2>Image [HTML]</h2>
        <div>
          <input type="text" class="html_image" onclick="select()" readonly value='<img src="<?=$url?>" attr="<?=$name?>">'>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</div>
