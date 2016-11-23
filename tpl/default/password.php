<div id="middle">
  <div id="content">
    <form method="post" enctype="multipart/form-data" action="<?=$conf['uri']?>/api/unlock.php">
    <?php
      if (isset($tpl['message'])) {
        echo '<p>' . $tpl['message'] . '</p>';
      }
    ?>
      <input class="inpt" type="password" id="password" name="password" placeholder="Password...">
      <button class="btn" id="btn-unlock">Get access</button>
    </form>
  </div>
</div>
