<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div style="margin-left:5%">
<h1>Edit/Create Route</h1>
<br/>

<?php


echo validation_errors();

if (!isset($routeid)) {
  $routeid = "";
} else {
  echo '<a href="/edit/delete/'.$routeid.'"'." onClick=\"return confirm('Really delete?');\">delete</a>";
}

if (!isset($routeinfo)) {
  $routename= "";
} else {
  $routename = $routeinfo['name'];
}

echo form_open('edit/create/'.$routeid);
echo "\n <fieldset style='width:60%'>";
echo '<legend> Route </legend>';
echo '<label for="routeid">Routeid.</label>';


$data = array(
              'name'        => 'routeid',
              'id'          => 'routeid',
              'value'       => $routeid,
              'maxlength'   => '10',
              'size'        => '10'
            );
echo form_input($data);

echo '<label for="routename">Routename:</label>';
$data = array(
              'name'        => 'routename',
              'id'          => 'routename',
              'value'       => $routename,
              'maxlength'   => '50',
              'size'        => '50'
            );
echo form_input($data);

echo "</fieldset><br/>";
?>
</br>
<table  style="width: 80%; border: 1px solid cornflowerblue; background: lavender;">
<tr>
<th>nr</th>
<th>time</th>
<th>busstop</th>
<th>lat</th>
<th>lon</th>
<th>delete</th>
</tr>

<?php
  $stopnr = 1;
  $i=0;
  if (isset($rows) && isset($routeinfo)) {
    foreach ($rows as $row) {      
      echo '<tr>';
      echo '<td><input id="stopnr" name="stopnr[]" type="text" size="3" maxlength="3" value="'.$row['stopnr'].'"/></td>';
      echo '<td><input id="stoptime" name="stoptime[]" type="text" size="8" maxlength="8" value="'.$row['stoptime'].'"/></td>';
      echo '<td><input id="bsname" name="bsname[]" type="text" size="40" maxlength="50" value="'.$row['name'].'"/></td>';
      echo '<td><input id="lat" name="lat[]" type="text" size="8" maxlength="10" value="'.$row['lat'].'"/></td>';
      echo '<td><input id="lon" name="lon[]" type="text" size="8" maxlength="10" value="'.$row['lon'].'"/></td>';
      echo '<td><input id="del" name="del_'.$i++.'" type="checkbox" "/></td>';
      echo '</tr>';
      $stopnr = $row['stopnr']+1;
    }
  }
?>

<tr>
<td>
<input id="stopnr" name="stopnr_new" type="text" size="3" maxlength="3" value="<?php echo $stopnr;?>"/>
</td>

<td>
<input id="stoptime" name="stoptime_new" type="text" size="8" maxlength="8" value="00:00"/>
</td>

<td>
<input id="bsname" name="bsname_new" type="text" size="40" maxlength="50"/>
</td>

<td>
<input id="lat" name="lat_new" type="text" size="8" maxlength="10"/>
</td>

<td>
<input id="lon" name="lon_new" type="text" size="8" maxlength="10"/>
</td>
</tr>

</table>
<br />

<?php
echo '<a target="_blank" href="/route/index/'.$routeid.'">Show Route</a>';
?>
<br/><br/>
<input type="submit" value="save" name="saveall" id="saveall"/> 

</form>
</div>
