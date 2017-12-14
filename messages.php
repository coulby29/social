<?php
  require_once('header.php');

  if (!$loggedin) die();

  if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
  else $view = $user;

  if (isset($_POST['text'])) {
    $text = sanitizeString($_POST['text']);

    if ($text != '') {
      $pm = substr(sanitizeString($_POST['pm']),0,1);
      $time = time();
      queryMysql("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
    }

    if ($view != '') {
      if ($view == $user) $name1 = $name2 = 'Your';
      else {
        $name1 = "<a href='members.php?view=$view'>$view</a>'s";
        $name2 = "$view's";
      }

      echo "<div class='main'><h3><$name1 Messages/h3></div>";
      showProfile($view);
    }

    echo <<<_END
   <form method='post' action='messages.php?view=$view'>
   Type here to leave a message:<br>
   // Наберите здесь текст, чтобы оставить сообщение
   <textarea name='text' cols='40' rows='3'></textarea><br>
   Public<input type='radio' name='pm' value='0' checked='checked'>
   Private<input type='radio' name='pm' value='1' />
   <input type='submit' value='Post Message'></form><br>
   // Опубликовать сообщение
_END;

  if (isset($_GET['erase'])) {
    $erase = sanitizeString($_GET['erase']);
    queryMysql("DELETE FROM messages WHERE id=$erase AND recip=$user");
  }

  $query = "SELECT * FROM messages WHERE recip=$view ORDER BY time DESC";
  $result = queryMysql($query);
  $num = $result -> num_rows;

  for ($j=0; $i < $num; ++$j) { 
    $row = fetch_array(MYSQLI_ASSOC);

    if ($row['pm'] == 0 || $row['auth'] == $user || $row['recip'] == $user) {
      echo date('M jS \'y g:ia:', $row['time']);
      echo "<a href='messages.php?view=$row[1]'>$row[1]</a>";

      if ($row['pm'] == 0)
        echo "wrote: &quot; $row[5]&quot;";
      else echo "whispered: <span class='whisper'>" .
        "&quote; $row[5]&quot</span>";

      if ($row['recip'] == $user)
        echo "[<a href='members.php?view=$view'".
      "&erase=$row[0]>erase</a>]";
      echo "<br>";
    }
  }
  }

  if (!$num) echo "<br><span class='info'>
    No messages yet</span><br><br>";

  echo "<br><a class='button'
    href='messages.php?view=$view'>Refresh messages</a>".
    "<a href='friends.php?view=$view'>View $name2 friends</a>"
?>

 </div><br>
 </body>
</html>