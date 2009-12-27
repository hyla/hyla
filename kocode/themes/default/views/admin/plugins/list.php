<?php
/*
 * views/admin/plugins/list.php
 * 
 * Display a list of plugins.
 *
 */
?>
<table id="plugin_table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Title</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($plugins as $plugin): ?>
		<tr>
			<td><?php echo $plugin->id; ?></td>
			<td><?php echo $plugin->name; ?></td>
			<td><?php echo $plugin->title; ?></td>
			<td><?php echo ($plugin->enabled)? 'Enabled':'Disabled'; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>