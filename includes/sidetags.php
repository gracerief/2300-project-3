<div id="sidetags">

  <h4><a href="index.php">Tags:</a></h4>
<?php
//$db = open_or_init_sqlite_db("accounts.sqlite", "init/init.sql");

/*$params = array(
  ':tag_name' => $tag_name
);*/

$tags = exec_sql_query($db, "SELECT * FROM tags;", NULL);
foreach($tags as $tag) {
  ?>
  <div class="side_tag">
    <li><a target="_blank" href="tagview.php?id=<?php echo $tag['id']?>"><?php echo htmlspecialchars($tag['tag_name'])?></a></li>
  </div>
  <?php
}
?>
</div>
