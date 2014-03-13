<script>

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
      "<td><span id='busicon" + i + "'><img src='/img/busstopgrey.png'/></span></td>" +
      "<td><span id='stopnr" + i + "'></span></td>" +
      "<td><span id='name" + i + "'></span></td>" +
      "<td><span id='stoptime" + i + "'></span></td>" +
      "<td><span id='logtime" + i + "'></span></td>" +
      "<td><span id='diff" + i + "'></span></td>" +
      "</tr>"
      );
    });
  })
  .done(updateTimeTable);
}

function updateMapStops(map, data)
{
  $.each(data, function(i, val) {
    var infowindow = new google.maps.InfoWindow({
      content: val.name
    });
    console.log(val.name + "/" + val.lat);
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(val.lat, val.lon),
        map: map,
        title: val.name
    });
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map, marker);
    });
  });
}

function initMap()
{
   var mapOptions = {
    zoom: 13,
    center: new google.maps.LatLng(47.089, 15.89)
  };

  var map = new google.maps.Map(document.getElementById('map_canvas'),
      mapOptions);
  return map;
}


$(document).ready(function() {
  var map = initMap();
  var routeid = <?php echo $route['id'];?>;
  initTimeTable(routeid);
  setInterval(function() {
  $.getJSON( "/route/data/" + routeid)
    .done(function(data) {
        updateTimeTable(data);
        updateMapStops(map, data);
      }
    );  
  }, 5000);

});

</script>

<h1><?php echo $route['name'].' / '.$route['id'];?></h1>

<div id="timetable_area">
<table id="timetable">
<tr><th></th><th>nr</th><th>stopname</th><th>target</th><th>actual</th><th>diff</th></tr>
</table>
</div>
<div id="map_canvas" class="bigmap" style="margin-top:2em; display:block">
</div>
