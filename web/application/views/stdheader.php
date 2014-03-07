<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<head>
<title><?php echo config_item('oet_h1');?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="/css/std.css">
<script src="<?php echo config_item('oet_jquery');?>"></script>
<script src="<?php echo config_item('oet_openlayers');?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>
function initialize() {
  var chicago = new google.maps.LatLng(41.875696,16);
  var mapOptions = {
    zoom: 11,
    center: chicago
  }

  var map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);

  var ctaLayer = new google.maps.KmlLayer({
    url: '/kml/test1.kml'
  });
  ctaLayer.setMap(map);
}

$(document).ready(function()
  {
    initialize();
  }
);
</script>


</head>
<div id="container">
  <div id="header">
  </div><!--End Header-->
    <div id="nav">
      <ul>
        <li><a href="/">Overview
        </a></li><li><a href="/routes">Routes
        </a></li><li><a href="#">Login
        </a></li></ul>
    </div><!--End nav-->
  <div id="wrapper">
    <div id="content">