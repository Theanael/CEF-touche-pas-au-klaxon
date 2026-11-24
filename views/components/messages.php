
<?php if (array_key_exists("error",$_GET)){?>
  <div class="alert alert-danger" role="alert">
    <?php echo $_GET['error']?>
  </div>
<?php }
  if (array_key_exists("success",$_GET)){ ?>
  <div class="alert alert-success" role="alert">
    <?php echo $_GET['success']?>
  </div>
<?php }
  if (array_key_exists("warning",$_GET)){ ?>
  <div class="alert alert-warning" role="alert">
    <?php echo $_GET['warning']?>
  </div>
<?php } ?>