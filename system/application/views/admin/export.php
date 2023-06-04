<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Export MySQL data to CSV file in CodeIgniter 3</title>

	
</head>
<body>

	<!-- Export Data -->
	<a href='<?= base_url()?>exportCSV'>Export</a><br><br>

	<!-- User Records -->
	<table border='1' style='border-collapse: collapse;'>
		<thead>
			<tr>
				<th>Username</th>
				<th>Mobile</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($userdata as $val){ ?>
				<tr>
				
				<td><?php echo $val->user_name; ?> </td>
				<td><?php echo $this->volanlib->decryptMob($val->mobile); ?> </td>
				</tr>
			
			<?php } ?>
		</tbody>
	</table>

</body>
</html>
<td>