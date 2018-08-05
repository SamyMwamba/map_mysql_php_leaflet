<?php

 require_once("db.php");

 $id = intval($_POST['company']);
 $details = strip_tags($_POST['details']);
 $latitude = strip_tags($_POST['latitude']);
 $longitude = strip_tags($_POST['longitude']);
 $telephone = strip_tags($_POST['telephone']);

 $conn->updateCompany( $id, $details, $latitude, $longitude, $telephone);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Company updated</title>
 </head>
 <body>
  <h1>Company has been updated</h1>
 </body>
</html>
