<?php

$current_user = check_login();

if (isset($_POST['logout'])) {
  log_out();
}

?>
<div id="header">
<h1><a href="index.php">Cornell Athletics</a></h1>
<h3><a href="index.php">2017-2018 IMAGE GALLERY</a></h3>

<div id="login_status">
<?php
if ($current_user) {
  ?>
  <p>Logged-in as: <strong><?php echo htmlspecialchars($current_user); ?></strong></p>
  <form method="post">
    <button name="logout" type="submit">(logout)</button>
  </form>

  <form action="uploadnew.php" method="post">
    <button action="submit" name="gotoupload">Upload New Image</button>
  </form>
  <?php
} else {
  ?>
  <p><a href="login.php">(login)</a></p>
  <?php
}
 ?>
</div>
</div>
