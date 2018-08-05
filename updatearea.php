<?php
 require_once("db.php");

 $id = intval($_POST['area']);
 $geo = strip_tags($_POST['geo']);

 $conn->updateArea( $id, $geo);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Area updated</title>
 </head>
 <body>
  <h1>Area has been updated</h1>
 </body>
</html>
