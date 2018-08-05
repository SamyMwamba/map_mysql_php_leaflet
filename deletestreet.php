<?php
 require_once</pre><pre class="code">("db.php");
 $arr = $conn->getStreetsList();
?>
<!DOCTYPE html>
<html>
<head>
 <title>Delete a street</title>
 <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
 <link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
 <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
 <script src="node_modules/leaflet/dist/leaflet.js"></script>
</head>
<body>
 <div id="map" style="width: 600px; height: 400px"></div><br />
 <form action="deletestreetdb.php" method="post">
  <h1>Delete a street</h1>
  <table cellpadding="5" cellspacing="0" border="0">
   <tbody>
    <tr align="left" valign="top">
     <td align="left" valign="top">Street name</td>
     <td align="left" valign="top"><select id="street" name="street"><option value="0">Please choose a street</option><?php for($i=0;$i<count($arr);$i++) { print '<option value="'.$arr[$i]['id'].'">'.$arr[$i]['name'].'</option>'; } ?></select></td>
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
  var polyLine;
  var draggableStreetMarkers = new Array();

  L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FteW13YW1iYSIsImEiOiJjamtnd2FlbDE1M2l5M3dtbGY1Z2wzbzJjIn0.7dqO-EqSJpSyxyUniLkUNQ', {
  maxZoom: 18,
  attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
  '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
  'Imagery © <a href="http://mapbox.com">Mapbox</a>',
  id: 'examples.map-i875mjb7'
  }).addTo(map);

  function resetStreet() {
   if(polyLine != null) {
    map.removeLayer( polyLine );
   }
   for(i=0; i<draggableStreetMarkers.length; i++) {
    map.removeLayer( draggableStreetMarkers[ i ]);
   }
   draggableStreetMarkers = new Array();
  }

  function addMarkerStreetPoint( latLng ) {
   var streetMarker = L.marker( [latLng.lat, latLng.lng], { draggable: true, zIndexOffset: 900 }).addTo(map);

   streetMarker.arrayId = draggableStreetMarkers.length;

   streetMarker.on('click', function() {
    map.removeLayer( draggableStreetMarkers[ this.arrayId ]);
    draggableStreetMarkers[ this.arrayId ] = "";
   });

   draggableStreetMarkers.push( streetMarker );
  }

  function drawStreet() {
   if(polyLine != null) {
    map.removeLayer( polyLine );
   }

   var latLngStreets = new Array();

   for(i=0; i < draggableStreetMarkers.length; i++) {
    if(draggableStreetMarkers[ i ] != "") {
     latLngStreets.push( L.latLng( draggableStreetMarkers[ i ].getLatLng().lat, draggableStreetMarkers[ i ].getLatLng().lng));
    }
   }

   if(latLngStreets.length > 1) {
    // create a red polyline from an array of LatLng points
    polyLine = L.polyline(latLngStreets, {color: 'red'}).addTo(map);
   }

   if(polyLine != null) {
    // zoom the map to the polyline
    map.fitBounds( polyLine.getBounds() );
   }
  }

  function getGeoPoints() {
   var points = new Array();
   for(var i=0; i < draggableStreetMarkers.length; i++) {
    if(draggableStreetMarkers[ i ] != "") {
     points[i] =  draggableStreetMarkers[ i ].getLatLng().lng + "," + draggableStreetMarkers[ i ].getLatLng().lat;
    }
   }
   $('#geo').val(points.join(','));
  }

  $( document ).ready(function() {
   $("#street").change(function() {
    resetStreet();
    for(var i=0; i <arr.length; i++) {
     if(arr[i]['id'] == $('#street').val()) {
      arrangePoints( arr[ i ]['geolocations']);
      drawStreet();
      break;
     }
    }
   });
  });

  function arrangePoints(geo) {
   var linesPin = geo.split(",");

   var linesLat = new Array();
   var linesLng = new Array();

   for(i=0; i<linesPin.length;i++) {
    if(i % 2) {
     linesLat.push(linesPin[i]);
    }else{
     linesLng.push(linesPin[i]);
    }
   }

   var latLngLine = new Array();

   for(i=0; i<linesLng.length;i++) {
    latLngLine.push( L.latLng( linesLat[i], linesLng[i]));
   }

   for(i=0; i < latLngLine.length; i++) {
    addMarkerStreetPoint( latLngLine[i]);
   }
  }

  var arr = JSON.parse( '<?php echo json_encode($arr) ?>' );
 </script>
</body>
</html>
