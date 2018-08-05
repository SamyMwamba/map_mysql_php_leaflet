<?php
 require_once("db.php");
 $companies = $conn->getCompaniesList();
 $streets = $conn->getStreetsList();
 $areas = $conn->getAreasList();
?>
<!Doctype html>
<html>
  <head>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />
    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
    <script src="node_modules/leaflet/dist/leaflet.js"></script>
  </head>
  <body>
      <div id="map" style="width: 100%; height: 550px"></div>
          <script>
           var map = L.map('map').setView([-11.66494,27.4837274], 13);
           L.tileLayer( 'https://api.mapbox.com/styles/v1/mapbox/streets-v10/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoic2FteW13YW1iYSIsImEiOiJjamtnd2FlbDE1M2l5M3dtbGY1Z2wzbzJjIn0.7dqO-EqSJpSyxyUniLkUNQ', {
           maxZoom: 18,
           attribution: 'Map data &copy; <a href="http://openstreetmap.org/"> OpenStreetMap </a> contributors, ' +
           '<a href="http://creativecommons.org/"> CC-BY-SA </a>, ' +
           'Imagery © <a href="http://mapbox.com">Mapbox</a>',
           id: 'examples.map-i875mjb7'
           }).addTo(map);
          </script>
          <script>
            var companies = JSON.parse( '<?php echo json_encode($companies) ?>' );
            var streets = JSON.parse( '<?php echo json_encode($streets) ?>' );
            var areas = JSON.parse( '<?php echo json_encode($areas) ?>' );
          </script>

          <script>
          $( document ).ready(function() {
                        addCompanies();
                        addStreets();
                        addAreas();
                        });
          </script>

          <script>
          function addCompanies() {
                      for(var i=0; i < companies.length; i++) {
                      var marker = L.marker( [companies[i]['latitude'], companies[i]['longitude']] ).addTo(map);
                      marker.bindPopup( "<b>" + companies[i]['company'] + "</b><br>Details:" + companies[i]['details'] + "<br />Telephone: " + companies[i]['telephone']);
                      }
                  }

        function addAreas() {
                     for(var i=0; i <areas.length; i++) {
                      var polygon = L.polygon( stringToGeoPoints( polygon[i]['geolocations']), { color: 'blue'}).addTo(map);
                      polygon.bindPopup( "<b>" + polygon[i]['name'] );
                     }
          }


      function addStreets() {
               for(var i=0; i <streets.length; i++) {
                var polyline = L.polyline( stringToGeoPoints( streets[i]['geolocations']), { color: 'red'}).addTo(map);
                polyline.bindPopup( "<b>" + streets[i]['name']);
               }
      }


      function stringToGeoPoints(geo) {
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

                 for(i=0; i < linesLng.length; i++) {
                  latLngLine.push( L.latLng( linesLat[i], linesLng[i]));
                 }
                 
                 return latLngLine;
        }
          </script>
 </body>
</html>
