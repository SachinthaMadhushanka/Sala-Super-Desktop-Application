<?php

try {

  $pdo = new PDO('mysql:host=localhost;dbname=sala_super_db', 'root', '');

} catch (PDOException $e) {

  echo $e->getMessage();


}


//echo'connection success';


?>
