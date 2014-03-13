<script>

function updateTimeTable(data)
{
  jQuery.each(data, function(i, val) {
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
    }
  });
}

function initTimeTable(routeid)
{
  $.getJSON( "/route/data/" + routeid, function( data ) {
    //~ console.log(json_data);
    jQuery.each(data, function(i, val) {
      $("#timetable").append(
      "<tr>" +
      "<td><span id='stopnr" + i + "'></span></td>" +
      "<td><span id='name" + i + "'></span></td>" +
      "<td><span id='stoptime" + i + "'></span></td>" +
      "<td><span id='logtime" + i + "'></span></td>" +
      "<td><span id='diff" + i + "'></span></td>" +
      /*"<td>" + val.name + "</td>" +
      "<td>" + val.stoptime + "</td>" +
      "<td>" + ((val.logtime != null) ? val.logtime : "") + "</td>" +
      "<td>" + ((val.diff != null) ? val.diff : "") + "</td>" +*/
      "</tr>"
      );
    });
  })
  .done(updateTimeTable);
  
  //updateTimeTable(json_data);
}



$(document).ready(function() {
  var routeid = <?php echo $route['id'];?>;
  initTimeTable(routeid);
  setInterval(function() {
  $.getJSON( "/route/data/" + routeid, updateTimeTable);
  }, 5000);



});

</script>

<h1><?php echo $route['name'].' / '.$route['id'];?></h1>

<div id="timetable_area">
<table id="timetable" >
<tr><th></th><th>station</th><th>target</th><th>actual</th><th>diff</th></tr>

</table>
</div>