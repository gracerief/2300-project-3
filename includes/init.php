<?php

$pages = array(
  "index" => "Home",
  "tagview" => "Tag View",
  "singleview" => "Single Image View",
  "uploadnew" => "Upload New Image"
);

$messages = array();

// Record a message to display to the user. (from lec14 init.php)
function record_message($message) {
  global $messages;
  array_push($messages, $message);
}

// Write out any messages to the user. (from lec14 init.php)
function print_messages() {
  global $messages;
  foreach ($messages as $message) {
    echo "<p><strong>" . htmlspecialchars($message) . "</strong></p>\n";
  }
}


// show database errors during development.
function handle_db_error($exception) {
  echo '<p><strong>' . htmlspecialchars('Exception : ' . $exception->getMessage()) . '</strong></p>';
}

// execute an SQL query and return the results.
function exec_sql_query($db, $sql, $params = array()) {
  try {
    $query = $db->prepare($sql);
    if ($query and $query->execute($params)) {
      return $query;
    }
  } catch (PDOException $exception) {
    handle_db_error($exception);
  }
  return NULL;
}

// open connection to database
function open_or_init_sqlite_db($db_filename, $init_sql_filename) {
  if (!file_exists($db_filename)) {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db_init_sql = file_get_contents($init_sql_filename);
    if ($db_init_sql) {
      try {
        $result = $db->exec($db_init_sql);
        if ($result) {
          return $db;
        }
      } catch (PDOException $exception) {
        // If we had an error, then the DB did not initialize properly,
        // so let's delete it!
        unlink($db_filename);
        throw $exception;
      }
    }
  } else {
    $db = new PDO('sqlite:' . $db_filename);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }
  return NULL;
}

// (from lec14 init.php)
// open connection to database
//$db = open_or_init_sqlite_db("accounts.sqlite", "init/init.sql");
//open_or_init_sqlite_db("images.sqlite", "init/init.sql");
//open_or_init_sqlite_db("tags.sqlite", "init/init.sql");
//open_or_init_sqlite_db("image_tag.sqlite", "init/init.sql");
$db = open_or_init_sqlite_db("box.sqlite", "init/init.sql");

function check_login() {
  global $db;

  if (isset($_COOKIE["session"])) {
    $session = $_COOKIE["session"];

    $sql = "SELECT * FROM accounts WHERE session = :session";
    $params = array(
      ':session' => $session
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      // Username is UNIQUE, so there should only be 1 record.
      $account = $records[0];
      return $account['username'];
    }
  }
  return NULL;
}

function log_in($username, $password) {
  global $db;

  if ($username && $password) {
    $sql = "SELECT * FROM accounts WHERE username = :username;";
    $params = array(
      ':username' => $username
    );
    $records = exec_sql_query($db, $sql, $params)->fetchAll();
    if ($records) {
      $account = $records[0];

      if ( $password == $account['password'] ) {

        $session = uniqid();
        $params = array(
          ':user_id' => $account['id'],
          ':username' => $username,
          ':session' => $session
        );
        $sql = "UPDATE accounts SET session = :session WHERE id = :user_id AND username = :username;";
        $result = exec_sql_query($db, $sql, $params);
        //$session = $result['session'];
        if ($result) {
          setcookie("session", $session, time()+3600);  /* expire in 1 hour */

          record_message("Logged in as $username.");
          $current_user = $username;
          return $current_user;
        } else {
          record_message("Log in failed.");
        }
      } else {
        record_message("Invalid username or password.");
      }
    } else {
      record_message("Invalid username or password.");
    }
  } else {
    record_message("No username or password given.");
  }
  return NULL;
}

function log_out() {
  global $current_user;
  global $db;

  if ($current_user) {
    $sql = "UPDATE accounts SET session = :session WHERE username = :username;";
    $params = array (
      ":username" => $current_user,
      ":session" => NULL
    );
    if (!exec_sql_query($db, $sql, $params)) {
      record_message("Log-out failed.");
    }

    //Remove the session from the cookie and force it to expire.
    setcookie("session", "", time()-3600);
    $current_user = NULL;
    record_message("Successfully logged-out.");
  }
}

if ('delete_image') {
  exec_sql_query($db, "DELETE FROM images WHERE id= :current_image_id", NULL);
}

// Check if we should login the user
if (isset($_POST['login'])) {
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $username = trim($username);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

  $current_user = log_in($username, $password);
} else {
  // check if logged in
  $current_user = check_login();
}

if (isset($_POST['logout'])) {
  log_out();
}

function deleteTag($tag_id) {
  $sql = 'DELETE FROM tags ' . 'WHERE id = :tag_id';
  $stmt = $this->pdo->prepare($sql);
  $stmt->bindValue(':task_id', $taskId);
  $stmt->execute();
}


?>
