<?php
include("includes/init.php");
$current_page_id="singleview";
$current_user = check_login();

$images = exec_sql_query($db, "SELECT * FROM images", NULL);
//$tags = exec_sql_query($db, "SELECT * FROM tags", NULL);

if (isset($_POST['logout'])) {
  log_out();
}
//if (isset($_POST['id'])) {
$current_image_id = $_GET['id'];
$params = array(
  'current_image_id' => $current_image_id
);
$current_image = exec_sql_query($db, "SELECT * FROM images WHERE id= :current_image_id;", $params)->fetchAll();
$current_image = $current_image[0];
//}

if (isset($_POST['delete_image_tag'])) {
  $tagname = $_POST['delete_image_tag'];
  $params = array(
    ':delete_image_tag' => $tagname
  );
  $sql1 = "DELETE FROM image_tag" . " WHERE tag_id = :delete_image_tag;";
  exec_sql_query($db, $sql1, $params);
}

if (isset($_POST['add_tag'])) {
  $tagname = $_POST['add_tag'];
  $tagnames = exec_sql_query($db, "SELECT tag_name FROM tags;")->fetchAll();
  if (!in_array($tagname, $tagnames)) {
    $params = array(
      ':tag_name' => $tagname
    );
    $sql2 = "INSERT INTO tags (tag_name)" . " VALUES (:tagname);";
  }
  $params = array(
    ':img_id' => $current_image_id
  );
  $existing_tags = exec_sql_query($db, "SELECT tag_name FROM image_tag WHERE image_id = :img_id;", $params)->fetchAll();
  if (!(in_array($tagname, $existing_tags))){
    $params = array(
      ':img_id' => $current_image_id,
      ':tag_name' => $tagname
    );
    $sql3 = "INSERT INTO image_tag (photo_id, tag_id)" . "VALUES (:img_id, :tag_name);";
    exec_sql_query($db, $sql3, $params);
  }
}

if (isset($_POST['delete_image'])) {
  $img_id = $current_image_id;
  exec_sql_query($db, "DELETE FROM images WHERE id='$img_id';");
  exec_sql_query($db, "DELETE FROM image_id WHERE photo_id='$img_id';");
  unlink(BOX_UPLOADS_PATH . $current_image['filename']);

  $test = exec_sql_query($db, "SELECT * FROM images WHERE id='$img_id';")->fetchAll(PDO::FETCH_ASSOC);
  if (empty($test)) {
    header('location:index.php');
  }
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Image View</title>
</head>

<body>
  <?php include("includes/header.php");?>


  <img src="images/<?php echo $current_image['filename'];?>" alt="<?php echo $current_image['img_alt']?>" class="single_img">
  <h3><?php echo htmlspecialchars($current_image['img_alt']);?></h3>
  <p><strong>Uploader</strong>: <?php echo htmlspecialchars($current_image['uploader']);?></p>
  <p><strong>Description</strong>: <?php echo htmlspecialchars($current_image['description']);?></p>
  <p><strong>Tags</strong>: <?php
    $params = array(
      ':current_image_id' => $current_image['id']
    );
    //$current_tag_ids = exec_sql_query($db, "SELECT tag_id FROM image_tag WHERE photo_id = :current_image_id;", $params)->fetchAll();
    $current_tag_ids = exec_sql_query($db, "SELECT * FROM tags INNER JOIN image_tag ON tags.id=image_tag.tag_id WHERE photo_id = :current_image_id;", $params)->fetchAll(PDO::FETCH_ASSOC);

    foreach ($current_tag_ids as $entry) {
      ?>
      <div class="single_tag">
        <a target="_blank" href="tagview.php?id=<?php echo $entry['tag_id']?>"><?php echo htmlspecialchars($entry['tag_name'])?>  </a>
      </div>
      <?php
    }
  ?></p>
<?php
if ($current_user) {
  //ADD TAG FUNCTION
  ?>
  <form id="addtag" action="">
    <label>Add a tag to this image:   </label><input type="text" name="newtag">  <button type="submit" name="add_tag"> add tag </button>
  </form>
  <?php
};

if ($current_image['uploader']==$current_user) {
  ?>
  <div id="uploader_opts">
  <form method="POST">
    <input type="hidden" value="'.$current_image_id.'" name="delete_file">
    <input type="submit" name="delete_image" value="Delete Image">
  </form>

  <form id="delete_tag" method="POST">
    <input type="hidden" value="'.$current_image_id.'" name="delete_tag">
    <select name="delete_image_tag">
      <option value="" selected disabled>Choose a tag to remove from this image</option>
      <?php
      foreach ($current_tag_ids as $entry) {
        ?>
        <option value="<?php echo $entry['tag_id']?>" selected><?php echo $entry['tag_name']?></option>
        <?php
      }
      ?>
    </select>
    <input name="tag_delete" type="submit" value="Remove this tag">
  </form>
</div>
<?php
}?>

</body>
</html>
