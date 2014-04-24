<?php if ($mock != '0'):?>
<script src="/js/geomock.js"></script>
<?php endif;?>

<script>

var map;
var path;
var info_markers = new Array();
var bus_marker = null;
function updateTimeTable(data)
{
  $.each(data, function(i, val) {
    if ($("#stopnr" + i).text() != val.stopnr) {
      $("#stopnr" + i).text(val.stopnr);
    }
    if ($("#name" + i).text() != val.name) {
      $("#name" + i).text(val.name);
    }
    if ($("#stoptime" + i).text() != val.stoptime) {
      $("#stoptime" + i).text(val.stoptime);
    }
    if (val.logtime != null && $("#logtime" + i).text() != val.logtime) {
      $("#logtime" + i).text(val.logtime);
    }
    if (val.diff != null &&$("#diff" + i).text() != val.diff) {
      $("#diff" + i).text(val.diff);
      if (Math.abs(val.diff) > 3*60)
      {
        $("#busicon" + i).html("<img src='/img/busstopred.png'/>");
      }
    }
  });
}

function initTimeTable(routeid)
{
  $.getJSON( "/route/data/" + routeid, function( data ) {
    jQuery.each(data, function(i, val) {
      $("#timetable").append(
      "<tr>" +
      "<td><span id='busicon" + i + "'><img src='/img/busstop.png'/></span></td>" +
      "<td><span id='stopnr" + i + "'></span></td>" +
      "<td><span id='name" + i + "'></span></td>" +
      "<td><span id='stoptime" + i + "'></span></td>" +
      "<td><span id='logtime" + i + "'></span></td>" +
      "<td><span id='diff" + i + "'></span></td>" +
      "</tr>"
      );
    });
  })
  .done(
    function(data) {
      updateTimeTable(data);
      initMapStops(map, data);
    }
  );
}

function initMapStops(map, data)
{
  if (data.length > 0)
  {
    var middle = Math.floor(data.length / 2);
    map.setCenter( 
      new google.maps.LatLng(data[middle].lat, 
                            data[middle].lon));
  }


  $.each(data, function(i, val) {
      var infomarker = new Object();
      var logtime = "";
      infomarker.logged = false;
      if (val.logtime != null) {
        logtime = val.logtime;
        infomarker.logged = true;
      }
      
      var infowindow = new google.maps.InfoWindow({
        maxWidth: 500,
        content: "<h1>" + val.name + "</h1>" +
        "target: " + val.stoptime + "<br />" +
        "actual: " + logtime + "<br />"
      });
      var marker = new google.maps.Marker({
          position: new google.maps.LatLng(val.lat, val.lon),
          map: map,
          title: val.name,
          icon: "/img/busstop.png"
      });
      
      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map, marker);
      });
      
      infomarker.marker = marker;
      infomarker.info = infowindow;
      info_markers.push(infomarker);
    });
    
}

function updateMapStops(map, data)
{
  $.each(data, function(i, val) {
    var infowindow = info_markers[i].info;
    if (val.logtime != null && !infowindow.logged) {
      infowindow.setContent("<h1>" + val.name + "</h1>" +
        "target: " + val.stoptime + "<br />" +
        "actual: " + val.logtime + "<br />");
      infowindow.logged = true;
    }
  });
}

function initMap()
{
   var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(0, 0)
  };

  map = new google.maps.Map(document.getElementById('map_canvas'),
      mapOptions);
      
      
  path = new google.maps.Polyline({
    geodesic: true,
    strokeColor: '#0000FF',
    strokeOpacity: 1.0,
    strokeWeight: 2
  });
  path.setMap(map);
  return map;
}




function drivelogs(routeid)
{
  $.getJSON( "/drivelogs/index/" + routeid)
    .done(function(data) {
      if (data.length == 0) return;
      var val = data[0];
      if (bus_marker == null) {
        bus_marker = new google.maps.Marker({
          position: new google.maps.LatLng(val.lat, val.lon),
          map: map,
          title: "route: " + routeid ,
          icon: "/img/bus2.png"
        });
      }
      else 
      {
        bus_marker.setPosition(new google.maps.LatLng(val.lat, val.lon))
      }
      
      var cooridnates = new Array();
      $.each(data, function(i, value) {
        cooridnates.push(new google.maps.LatLng(value.lat, value.lon));
      });
      path.setPath(cooridnates);
      
    }
  );
}

$(document).ready(function() {
  map = initMap();
  var routeid = <?php echo $route['id'];?>;
  initTimeTable(routeid);
  drivelogs(routeid);
  setInterval(function() {
  $.getJSON( "/route/data/" + routeid)
    .done(function(data) {
        updateTimeTable(data);
        updateMapStops(map, data);
      }
    );
    drivelogs(routeid);
  }, 2000);

});

</script>

<script>

var logging;
var logtimer;
var routestations;
var routeid = <?php echo $route['id'];?>;

//------------------------------------------------------------------------------
// http://stackoverflow.com/questions/27928/how-do-i-calculate-distance-between-two-latitude-longitude-points
function getDistanceFromLatLonInMeter(lat1, lon1, lat2, lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2 - lat1);  // deg2rad below
  var dLon = deg2rad(lon2 - lon1); 
  var a = 
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * 
    Math.sin(dLon / 2) * Math.sin(dLon / 2)
    ; 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)); 
  var d = R * c; // Distance in km
  return d * 1000.0;
}

function deg2rad(deg) {
  return deg * (Math.PI/180)
}
//------------------------------------------------------------------------------


function logPosition(routeid, current_lat, current_lon)
{
  var rpid = -1;
  $.each(routestations, function(i, rs) {
    if (rs.logged == false &&
      getDistanceFromLatLonInMeter(rs.lat, rs.lon, current_lat, current_lon) <= 60.0)
    {
      rpid = rs.routepointid;
      rs.logged = true;
      return false;
    }
  });
  
  $.post("/logging/log/", 
      {
        routeid: routeid,
        lat: current_lat,
        lon: current_lon,
        routepointid: rpid
      }, 
    function(data, textStatus) {
    //data contains the JSON object
    //textStatus contains the status: success, error, etc
    }, "json");

}

function initRouteStations(data)
{
  routestations = new Array();
  $.each(data, function(i, val) {
    var pos = val;
    pos.logged = false;
    routestations.push(pos);
  });
}


var options = 
{
  enableHighAccuracy: false,
  timeout: 5000,
  maximumAge: 0
};

function success(pos) 
{
  var crd = pos.coords;
  console.log('Your current position is:');
  console.log('Latitude : ' + crd.latitude);
  console.log('Longitude: ' + crd.longitude);
  console.log('More or less ' + crd.accuracy + ' meters.');
  logPosition(routeid, crd.latitude, crd.longitude);
}

function error(err) 
{
  console.warn('ERROR(' + err.code + '): ' + err.message);
}

function startLogging()
{
  navigator.geolocation.getCurrentPosition(success, error, options);
  timer = setInterval(
    function() {
      navigator.geolocation.getCurrentPosition(success, error, options);
    }
  ,10000);
}

function stopLogging()
{
  clearInterval(timer);
}

$(document).ready(function() {
  logging = false;
  $.getJSON( "/route/routestations/" + routeid)
    .done(function(data) {
      initRouteStations(data);
    }
  );
  
  $("#start_button").click(function() {
    if (logging) {
      logging = false;
      $(this).text("Start Logging");
      stopLogging();
    }
    else {
      logging = true;
      $(this).text("Stop Logging");
      startLogging();
    }
  });

});

</script>

<h1><?php echo $route['name'].' / '.$route['id'];?></h1>

<div id="start_stop_buttons" style="margin-top: 1em;margin-bottom: 1em">
<button type="button" id="start_button">Start Logging</button>
</div>
<div id="last_log">
</div>
<div id="status">
</div>

<div id="timetable_area">
<table id="timetable">
<tr><th></th><th>nr</th><th>stopname</th><th>target</th><th>actual</th><th>diff</th></tr>
</table>
</div>
<div id="map_canvas" class="routemap">
</div>
<div style="clear: both"></div>
