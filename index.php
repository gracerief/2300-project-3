<?php
include("includes/init.php");
$current_page_id="index";
$current_user = check_login();



$images = exec_sql_query($db, "SELECT * FROM `images`;", NULL);
$tags = exec_sql_query($db, "SELECT * FROM tags", NULL);
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Home</title>
</head>

<body>
  <?php include("includes/header.php");?>

<?php include("includes/sidetags.php")?>


  <div id="full_gallery">
    <?php
    foreach ($images as $image) {
      ?>
      <div class="index_image">
        <a target="_blank" href="singleview.php?id=<?php echo $image['id']?>"><img src="images/<?php echo htmlspecialchars($image['filename'])?>" alt="<?php echo $image['img_alt']?>"></a>
      </div>
      <?php
    }
     ?>
  </div>
  <br>

</body>
</html>
