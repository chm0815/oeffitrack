<h1>Edit</h1>

<div id="routesdiv">
<ul>
<?php foreach($rows as $row): ?>
<li><a href="/edit/route/<?php echo $row['id'];?>"><?php echo $row['name'].' / '.$row['id'];?></a></li>
<?php endforeach; ?>
</ul>
</div>