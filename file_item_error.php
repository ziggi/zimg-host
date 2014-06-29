<?php
$name = htmlentities($_GET['name']);
$error = htmlentities($_GET['error']);
?>
<div class="file-item">
  <p class="error_text">File "<?=$name?>" has been not uploaded. <?=$error?></p>
</div>