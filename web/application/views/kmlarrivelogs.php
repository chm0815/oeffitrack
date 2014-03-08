<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>Arrivelogs</name>
    <description><?php echo $desc; ?></description>
    <Style id="routepoint">
      <IconStyle>
        <Icon>
          <href><?php echo base_url();?>img/busstop.png</href>
        </Icon>
      </IconStyle>
	</Style>
<?php	foreach ($rows as $row): ?>
    <Placemark>
      <name><?php echo $row['name'];?></name>
      <styleUrl>#routepoint</styleUrl>
		<description>
<![CDATA[
<h3><?php echo $routename;?></h3>
<?php echo 'Route '.$row['routeid'].' | stopnr: '.$row['stopnr']."\r\n";?>
<hr>
<strong>Target: <?php echo $row['stoptime']; ?> | Actual: <?php echo $row['logtime'];?></strong>
</br>
]]>
		</description>
		<Point>
		  <coordinates><?php echo $row['lon'].",".$row['lat'];?></coordinates>
		</Point>
	</Placemark>
<?php endforeach; ?>
  </Document>
</kml>