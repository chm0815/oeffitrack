<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  $config['oet_version'] = '1.0 DEV';
  $config['oet_h1'] = 'Oeffitrack Demo - Version '.$config['oet_version'];
  
  // jquery path: change to http://code.jquery.com/jquery-latest.min.js to reduce traffic
  $config['oet_jquery'] = '/js/jquery-1.11.0.min.js';
  
  // OpenLayers path: change to http://openlayers.org/api/OpenLayers.js to reduce traffic
  $config['oet_openlayers'] = '/js/OpenLayers.js';


  // googlemaps or openlayers
  //$config['oet_mapapi'] = 'googlemaps';//'googlemaps';
  //$config['oet_mapapikey'] = 'ABQIAAAAQm226KlKdrMHcrSP9sdxLxQrq-Ndf1GrLz98GADynUASDyV02hSOv1zkOMbYGKiDXCrWR0lk1G20zQ';
  //$config['oet_mapapikey'] = 'ABQIAAAAYicwjjqGNtWxK3JGcVOxwxTE20y9UNhcBun2UkQ7-2Mxa11U5hRAKUUnbg-TT3wQtY4f7Hq7DeK1eg';

  // google map zoom on homepage 
  $config['oet_zoom'] = 10;
  $config['oet_lat'] = 47.07;
  $config['oet_lon'] = 15.99;
?>