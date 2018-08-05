<!Doctype html>
<html>
  <head>
    <script src='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v0.47.0/mapbox-gl.css' rel='stylesheet' />

    <link rel="stylesheet" href="node_modules/leaflet/dist/leaflet.css"/>
<script src="node_modules/leaflet/dist/leaflet.js"></script>
  </head>
  <body>

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
 </body>
</html>
