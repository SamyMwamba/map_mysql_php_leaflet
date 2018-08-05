<?php
 require_once("db.php");

 $area = strip_tags($_POST['area']);
 $geo = strip_tags($_POST['geo']);

 $conn->addArea( $area, $geo);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Area added</title>
 </head>
 <body>
  <h1>Area has been added</h1>
 </body>
</html>
