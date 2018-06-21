<?php
include("includes/init.php");

// declare the current location, utilized in header.php
$current_page_id="login";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Log In</title>
</head>

<body>
  <?php include("includes/header.php");?>

  <div id="content-wrap">
    <h1>Log in</h1>

    <?php
    print_messages();
    ?>

    <form id="loginForm" action="login.php" method="post">
      <ul>
        <li>
          <label>Username:</label>
          <input type="text" name="username" required/>
        </li>
        <li>
          <label>Password:</label>
          <input type="password" name="password" required/>
        </li>
        <li>
          <button name="login" type="submit">Log In</button>
        </li>
      </ul>
    </form>
  </div>

  <!--?php include("includes/footer.php");?-->
</body>

</html>
