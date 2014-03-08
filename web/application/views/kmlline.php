<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name><?php echo $name;?></name>
    <description><?php echo $desc;?></description>
    <Style id="linestyle">
      <LineStyle>
        <color>ffff0000</color>s
        <width>4</width>
      </LineStyle>
    </Style>

  <Style id="bus">
    <IconStyle>
        <Icon>
          <href><?php echo base_url();?>img/bus.png</href>
        </Icon>
      </IconStyle>
  </Style>

    <Placemark>

      <name><?php echo $name; ?></name>
      <styleUrl>#linestyle</styleUrl>
      <LineString>
        <coordinates>
<?php

    foreach ($rows as $row)
    {
      echo $row['lon'].",".$row['lat']."\r\n";
    }
    if (isset($rows[0]))
    {
      $first_row = $rows[0]; // to show the bus on the first coordinate
    }
?>
        </coordinates>
      </LineString>
    </Placemark>
<?php if (isset($first_row) && $showbus == true):?>
  <Placemark>
      <name><?php echo $routeid.' / '.$first_row['logtime'];?></name>
      <styleUrl>#bus</styleUrl>
    <description>
<![CDATA[

<?php 
  echo "</br></br>";
  echo 'Pos:'.$first_row['lon'].'|'.$first_row['lat']; 
  echo "</br>";
?>

</br>
]]>
    </description>
    <Point>
      <coordinates><?php echo $first_row['lon'].",".$first_row['lat'];?></coordinates>
    </Point>
  </Placemark>
<?php endif;?>
  </Document>
</kml>
