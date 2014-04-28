<h1>New</h1>
<div id="new_route">
<a href="/edit/newedit/">New Route</a>
</div>

<h1>Edit</h1>

<div id="routesdiv">
<ul>
<?php foreach($rows as $row): ?>
<li><a href="/edit/newedit/<?php echo $row['id'];?>"><?php echo $row['name'].' / '.$row['id'];?></a></li>
<?php endforeach; ?>
</ul>
</div>