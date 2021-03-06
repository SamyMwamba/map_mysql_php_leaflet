<?php
 require_once("db.php");
 $arr = $conn->getAreasList();
?>
<!DOCTYPE html>
<html>
<head>
 <title>Delete an area</title>
 <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
 <link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
 <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
 <script src="node_modules/leaflet/dist/leaflet.js"></script>
</head>
<body>
 <div id="map" style="width: 600px; height: 400px"></div><br />
 <form action="deleteareadb.php" method="post">
  <h1>Delete an area</h1>
  <table cellpadding="5" cellspacing="0" border="0">
   <tbody>
    <tr align="left" valign="top">
     <td align="left" valign="top">Area name</td>
     <td align="left" valign="top"><select id="area" name="area"><option value="0">Please choose an area</option><?php for( $i=0; $i < count($arr); $i++) { print '<option value="'.$arr[$i]['id'].'">'.$arr[$i]['name'].'</option>'; } ?></select></td>
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
  var polygon;
  var draggableAreaMarkers = new Array();

  L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FteW13YW1iYSIsImEiOiJjamtnd2FlbDE1M2l5M3dtbGY1Z2wzbzJjIn0.7dqO-EqSJpSyxyUniLkUNQ', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
  '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
  'Imagery © <a href="http://mapbox.com">Mapbox</a>',
  id: 'examples.map-i875mjb7'
  }).addTo(map);

  function resetArea() {
   if(polygon != null) {
    map.removeLayer( polygon );
   }
   for(i=0; i < draggableAreaMarkers.length; i++) {
    map.removeLayer( draggableAreaMarkers[i] );
   }
   draggableAreaMarkers = new Array();
  }

  function addMarkerAreaPoint(latLng) {
   var areaMarker = L.marker( [latLng.lat, latLng.lng], { draggable: true, zIndexOffset: 900}).addTo(map);

   areaMarker.arrayId = draggableAreaMarkers.length;

   areaMarker.on('click', function() {
    map.removeLayer( draggableAreaMarkers[ this.arrayId ]);
    draggableAreaMarkers[ this.arrayId ] = "";
   });

   draggableAreaMarkers.push( areaMarker );
  }

  function drawArea() {
   if(polygon != null) {
    map.removeLayer( polygon );
   }

   var latLngAreas = new Array();

   for(i=0; i < draggableAreaMarkers.length; i++) {
    if(draggableAreaMarkers[i] != "") {
     latLngAreas.push( L.latLng( draggableAreaMarkers[ i ].getLatLng().lat, draggableAreaMarkers[ i ].getLatLng().lng));
    }
   }

   if(latLngAreas.length > 1) {
    // create a blue polygon from an array of LatLng points
    polygon = L.polygon( latLngAreas, { color: 'blue' }).addTo(map);
   }

   if(polygon != null) {
    // zoom the map to the polygon
    map.fitBounds( polygon.getBounds() );
   }
  }

  function getGeoPoints() {
   var points = new Array();
   for(var i=0; i <draggableAreaMarkers.length; i++) {
    if(draggableAreaMarkers[ i ] != "") {
     points[i] =  draggableAreaMarkers[ i ].getLatLng().lng + "," + draggableAreaMarkers[ i ].getLatLng().lat;
    }
   }
   $('#geo').val(points.join(','));
  }

  $( document ).ready(function() {
   $("#area").change(function() {
    resetArea();
    for(var i=0;i<arr.length;i++) {
     if(arr[i]['id'] == $('#area').val()) {
      arrangePoints(arr[i]['geolocations']);
      drawArea();
      break;
     }
    }
   });
  });

  function arrangePoints( geo ) {
   var linesPin = geo.split(",");

   var linesLat = new Array();
   var linesLng = new Array();

   for(i=0; i < linesPin.length;i++) {
    if(i % 2) {
     linesLat.push(linesPin[i]);
    }else{
     linesLng.push(linesPin[i]);
    }
   }

   var latLngLine = new Array();

   for(i=0; i < linesLng.length; i++) {
    latLngLine.push( L.latLng( linesLat[i], linesLng[i]));
   }

   for(i=0; i < latLngLine.length;i++) {
    addMarkerAreaPoint( latLngLine[i]);
   }
  }

  var arr = JSON.parse( '<?php echo json_encode($arr) ?>' );
 </script>
</body>
</html>
