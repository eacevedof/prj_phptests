<?php
/*
 * @file: help_gmapsv3 1.0.0
 * @info: Prueba Helper gmapsv3
 * Se puede pasar el parámetro nohome para evitar que cree el link HOME
 * 
*/
include(TFW_DOCROOTDS."vendor/autoload.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map" style="width:80%; height:800px;"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCqT1ufIPEKT4j8vBG-qdMfqt0-WVZ-2OQ&callback=initMap"
    async defer></script>
  </body>
</html>