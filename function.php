<?php
$hn = 'localhost';
$un = 'root';
$pw = '';
$db = 'social';
$appname = 'Social Network';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn -> connect_error) die($conn -> connect_error);

function createTable($name, $query) {
  queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
  return "Таблица $name создана или уже существует<br>";
}

function queryMysql($query) {
  global $conn;
  $result = $conn -> query($query);
  if (!$result) die ($conn -> error);
  return $result;
}

function destroySession() {
  $_SESSION = array();

  if (session_id() != '' || isset($COOKIE[session_name()]))
    setcookie(session_name(),'',time()-2592000,'');

  session_destroy();    
}

function sanitizeString($var) {
  global $conn;
  $var = strip_tags($var);
  $var = htmlentities($var);
  $var = stripslashes($var);
  return $conn -> real_escape_string($var);
  //return $var;
}

function showProfile($user) {
  if (file_exists("$user.jpg"))
    echo "<img src='$user.jpg' align='left'>";

  $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

  if ($result -> num_rows) {
    $row = $result -> fetch_array(MYSQLI_ASSOC);
    echo stripslashes($row['text']).
    "<br style='clear:left;'><br>";
  }
}



?>


