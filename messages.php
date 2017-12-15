<?php
 require_once 'header.php';
 if (!$loggedin) die();
 if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
 else $view = $user;
 if (isset($_POST['text']))
 {
 $text = sanitizeString($_POST['text']);
 if ($text != "")
 {
 $pm = substr(sanitizeString($_POST['pm']),0,1);
 $time = time();
 queryMysql("INSERT INTO messages VALUES(NULL, '$user',
 '$view', '$pm', $time, '$text')");
 }
  }
 if ($view != "")
 {
 if ($view == $user) $name1 = $name2 = "Your"; // Ваши
 else
 {
 $name1 = "<a href='members.php?view=$view'>$view</a>'s";
 $name2 = "$view's";
 }
 echo "<div class='main'><h3>$name1 Messages</h3>"; 
  showProfile($view);
 echo <<<_END
 <form method='post' action='messages.php?view=$view'>
 Type here to leave a message:<br>
 <textarea name='text' cols='40' rows='3'></textarea><br>
 Public<input type='radio' name='pm' value='0' checked='checked'>
 Private<input type='radio' name='pm' value='1' />
 <input type='submit' value='Post Message'></form><br>
_END;
 if (isset($_GET['erase']))
 {
 $erase = sanitizeString($_GET['erase']);
 queryMysql("DELETE FROM messages WHERE id=$erase AND recip='$user'");
 }
 $query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
 $result = queryMysql($query);
 $num = $result->num_rows;
 for ($j = 0 ; $j < $num ; ++$j)
 {
 $row = $result->fetch_array(MYSQLI_NUM);
 if ($row[3] == 0 || $row[1] == $user || $row[2] == $user)
 {
 echo date('M jS \'y g:ia:', $row[4]);
 echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
 if ($row[3] == 0)
 echo "wrote: &quot;$row[5]&quot; ";
 // Сообщил
 else echo "whispered: <span class='whisper'>" .
 "&quot;$row[5]&quot;</span> ";
 // Прошептал
 if ($row[2] == $user)
 echo "[<a href='messages.php?view=$view" .
 "&erase=$row[0]'>erase</a>]";
 // Стереть

 
 echo "<br>";
 }
 }
  }
 if (!$num) echo "<br><span class='info'>
 No messages yet</span><br><br>";
 // Пока сообщений нет
 echo "<br><a class='button'
 href='messages.php?view=$view'>Refresh messages</a>".
 // Обновить сообщения
 "<a class='button' href='friends.php?view=$view'>View $name2 friends</a>";
?>
 </div><br>
 </body>
</html>