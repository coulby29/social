<?php
  require_once('header.php');

  if (!$loggedin) die();

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else $view = $user;

  if ($view == $user) {
    $name1 = $name2 = "Your";
    $name3 = "You are";
  }
  else {
    $name1 = "<a href='members.php?view=$view'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
  }

  echo "<div class='main'></div>";

  //showProfile($view);

  $followers = array();
  $following = array();

  $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
  $num = $result -> num_rows;

  for ($j=0; $j < $num; ++$j) { 
    $row = $result -> fetch_array(MYSQLI_ASSOC);
    $followers[$j] = $row['friend'];
  }

  $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
  $num = $result -> num_rows;

  for ($j=0; $j < $num; ++$j) { 
    $row = $result -> fetch_array(MYSQLI_ASSOC);
    $following[$j] = $row['user'];
  }

  $mutual = array_intersect($followers, $following);
  $followers = array_diff($followers, $mutual);
  $following = array_diff($following, $mutual);
  $friends = FALSE;

  if (sizeof($followers)) {
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach ($followers as $friend) {
      echo "<li><a href='members.php?views=$friend'>$friend</a>";      
    echo "</ul>";
    $friends = TRUE;
    }
  }

  if (sizeof($following)) {
    echo "<span class='subhead'>$name2 following</span><ul>";
    foreach ($following as $friend) {
      echo "<li><a href='members.php?views=$friend'>$friend</a>";      
    echo "</ul>";
    $friends = TRUE;
    }
  }

  if (!$friends) echo "<br>Пока у Вас не друзей<br><br>";
  echo "<a href='members.php?view=$view' class='button'>" .
  "Просмотр сообщений от $name2</a>";
?>
 </div><br>
 </body>
</html>





