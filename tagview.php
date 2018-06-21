<?php
include("includes/init.php");

$current_page_id="tagview";


$current_tag_id = $_GET['id'];
$params = array(
  'current_tag_id' => $current_tag_id
);
//$tag_entries = exec_sql_query($db, "SELECT * FROM image_tag WHERE tag_id = :current_tag_id;", $params);
$current_images = exec_sql_query($db, "SELECT * FROM images INNER JOIN image_tag ON images.id=image_tag.photo_id WHERE tag_id = :current_tag_id;", $params)->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Image Gallery View</title>
</head>

<body>
  <?php include("includes/header.php");?>

  <?php include("includes/sidetags.php")?>

    <div id="tag_gallery">
      <?php
      foreach ($current_images as $entry) {
        ?>
        <div class="tags_image">
          <a target="_blank" href="singleview.php?id=<?php echo $entry['id']?>"><img src="images/<?php echo htmlspecialchars($entry['filename'])?>" alt="<?php echo $entry['img_alt']?>"></a>
        </div>
        <?php
      }

      if (empty($current_images)) {
        ?>
        <h3> No images to display!</h3>
        <?php
      }
       ?>
    </div>

</body>
</html>
