<?php
 require_once("db.php");

 $id = intval($_POST['street']);
 $geo = strip_tags($_POST['geo']);

 $conn->updateStreet( $id, $geo);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Street updated</title>
 </head>
 <body>
  <h1>Street has been updated</h1>
 </body>
</html>
