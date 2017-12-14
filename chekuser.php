<?php
require_once('function.php');

if (isset($_POST['user'])) {
  $user = sanitizeString($_POST['user']);
  $result = queryMysql("SELECT * FROM members WHERE user='$user'");

  if ($result->num_rows) 
    echo "<span class='taken'>&nbsp;&#x2718;Это имя занято</span>";
  else echo "<span class='taken'>&nbsp;&#x2714;Это имя доступно</span>";
}
?>
