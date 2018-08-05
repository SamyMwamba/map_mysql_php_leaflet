<?php
 require_once("db.php");

 $id = intval($_POST['street']);

 $conn->deleteStreet($id);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Street deleted</title>
 </head>
 <body>
  <h1>Street has been deleted</h1>
 </body>
</html>
