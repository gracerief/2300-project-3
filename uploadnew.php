<?php
include("includes/init.php");
$current_page_id="uploadnew";

//http://php.net/manual/en/features.file-upload.post-method.php
//https://stackoverflow.com/questions/17563512/use-php-and-mysql-to-add-images-to-a-gallery
$current_user=check_login();
const MAX_FILE_SIZE = 1000000;
const BOX_UPLOADS_PATH = "uploads/documents/";

if (isset($_POST["upload"])) {
  $upload_info = $_FILES["img_file"];
  $upload_desc = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $upload_alt = filter_input(INPUT_POST, 'img_alt', FILTER_SANITIZE_STRING);
  $upload_user = $current_user;

  if ($upload_info['error'] == UPLOAD_ERR_OK) {
    $upload_name = basename('uploads/' . $upload_info["name"]) . strtolower(pathinfo($upload_info, PATHINFO_EXTENSION) );

    $sql = "INSERT INTO `images` (filename, img_alt, description, uploader) VALUES (:filename, :img_alt, :description, :username);";
    $params = array(
      ':filename' => 'uploads/' . $upload_name,
      ':img_alt' => $upload_alt,
      ':description' => $upload_desc,
      ':username' => $upload_user
    );

    $result = exec_sql_query($db, $sql, $params);
    if ($result) {
      $file_id = $db->lastInsertId("id");
      if (move_uploaded_file($upload_info["tmp_name"], BOX_UPLOADS_PATH . "$upload_name")){
        array_push($messages, "Your file has been uploaded.");
      }
    } else {
      array_push($messages, "Failed to upload file.");
    }
  } else {
    array_push($messages, "Failed to upload file.");
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <link rel="stylesheet" type="text/css" href="styles/all.css" media="all" />

  <title>Upload New</title>
</head>
<body>
  <?php include("includes/header.php");?>

<?php
  print_messages();
  ?>
  <?php
if ($current_user) {
  ?>
  <form id="uploadnew" action="" method="post" enctype="multipart/form-data">
      <label>Image Title:</label> <input type="text" name="img_alt"><br>
      <label>Description:</label> <input type="text" name="description"><br>
      <label>Image Upload: </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
        <input type="file" name="img_file" required><br>
      <label>Uploader Acount: </label> <strong><?php echo htmlspecialchars($current_user)?></strong><br>
      <input type="submit" value="upload" name="upload">
  </form>
<?php
}
?>

</body>
</html>
