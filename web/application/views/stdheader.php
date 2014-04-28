<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<head>
<title><?php echo config_item('oet_h1');?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/css/std.css">
<script src="<?php echo config_item('oet_jquery');?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
/*var timer;
var test_marker;
var map;
function initMap() 
{
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(47.077349, 15.994597)
  }

  map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
  $.getJSON( "/drivelogs/index/1", function( data ) {
    jQuery.each(data, function(i, val) {
      var marker = new google.maps.Marker({
        position: new google.maps.LatLng(val.lat, val.lon),
        map: map,
        title: 'XYZ!'
      });
    }
    );
  });
  
  test_marker = new google.maps.Marker({
        position: new google.maps.LatLng(47.077349, 15.994597),
        map: map,
        title: 'Test Marker',
        icon: '/img/bus2.png',
        maxWidth: 200
      });
  
  var contentString = '<h1>This is the Bus</h1>' + 
                      'S47 Großwilfersdorf-Graz<br />' + 
                      'Soll: 10:30 Ist: 10:31<br />';
  var infowindow = new google.maps.InfoWindow({
      content: contentString
  });
  google.maps.event.addListener(test_marker, 'click', function() {
    infowindow.open(map, test_marker);
  });
  
  
}

$(document).ready(function() {
    initMap();
    timer = setInterval(function () { 
    var lat = test_marker.getPosition().lat();
    var lon = test_marker.getPosition().lng();
    var pos = new google.maps.LatLng(lat + 0.001, lon + 0.001);
    test_marker.setPosition(pos);
    console.log("setpos");
    map.setCenter(pos);
  }, 1000);
  }
);*/
</script>


</head>
<div id="container">
  <div id="header">
  </div><!--End Header-->
    <div id="nav">
      <ul>
        </a></li><li><a href="/routes">Routes
        <?php if (!$this->session->userdata('logged_in')): ?>
        </a></li><li><a href="/main/login">Login
        <?php else:?>
        </a></li><li><a href="/edit/index">Edit
        </a></li><li><a href="/logging/index">Logging
        </a></li><li><a href="/main/logout">Logout
        <?php endif; ?>
        </a></li></ul>
    </div><!--End nav-->
  <div id="wrapper">
    <div id="content">