<?php
 require_once("db.php");
 $arr = $conn->getCompaniesList();
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Delete a company</title>
  <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
  <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
  <script src="node_modules/leaflet/dist/leaflet.js"></script>
 </head>
 <body>
  <div id="map" style="width: 100%; height: 550px"></div>
  <form action="deletecompanydb.php" method="POST">
   <h1>Delete a company</h1>
   <table cellpadding="5" cellspacing="0" border="0">
    <tbody>
     <tr align="left" valign="top">
      <td align="left" valign="top">Company name</td>
      <td align="left" valign="top"><select id="company" name="company"><option value="0">Please choose a company</option><?php for( $i=0; $i < count($arr); $i++) { print '<option value="'.$arr[$i]['id'].'">'.$arr[$i]['company'].'</option>'; } ?></select></td>
     </tr>
     <tr align="left" valign="top">
      <td align="left" valign="top"></td>
      <td align="left" valign="top"><input type="submit" value="Delete"></td>
     </tr>
    </tbody>
   </table>
  </form>
  <script>
  var map = L.map('map').setView([-11.66494,27.4837274], 13);
  L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FteW13YW1iYSIsImEiOiJjamtnd2FlbDE1M2l5M3dtbGY1Z2wzbzJjIn0.7dqO-EqSJpSyxyUniLkUNQ', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
  '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
  'Imagery © <a href="http://mapbox.com">Mapbox</a>',
  id: 'examples.map-i875mjb7'
  }).addTo(map);

   function putDraggable() {
    /* create a draggable marker in the center of the map */
    draggableMarker = L.marker([ map.getCenter().lat, map.getCenter().lng], {draggable: true, zIndexOffset: 900}).addTo(map);

    /* collect Lat,Lng values */
    draggableMarker.on('dragend', function(e) {
     $("#lat").val(this.getLatLng().lat);
     $("#lng").val(this.getLatLng().lng);
    });
   }

   $( document ).ready(function() {
    putDraggable();

    $("#company").change(function() {
     for(var i=0; i <arr.length; i++) {
      if(arr[i]['id'] == $('#company').val()) {
       map.panTo([arr[i]['latitude'], arr[i]['longitude']]);
       draggableMarker.setLatLng([arr[i]['latitude'], arr[i]['longitude']]);
       break;
      }
     }
    });

   });

   var arr = JSON.parse( '<?php echo json_encode($arr) ?>' );
  </script>
 </body>
</html>
