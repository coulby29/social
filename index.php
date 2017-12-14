<?php
 require_once 'header.php';
 echo "<br><span class='main'>Welcome to $appname,";
 // Добро пожаловать в ...
 if ($loggedin) echo " $user, вы вошли на сайт";
 // вы вошли на сайт
 else echo 'Заригестрируйтесь или войдите на сайт';
 // Пожалуйста, зарегистрируйтесь и (или) войдите на сайт
?>
 </span><br><br>
 </body>
</html>