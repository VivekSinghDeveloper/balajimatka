<!DOCTYPE html>
<html>
<head>
<style>
.content {
  max-width: 500px;
  margin: auto;
}
table, td, th {
  border: 1px solid black;
}

table {
  width: 50%;
  border-collapse: collapse;
}
</style>
</head>
<body>
<div class="content">

<h2>Mobile Number Table</h2>

<table>
 <tr>
    <th>#</th>
    <th>Mobile Number</th>

  </tr>
  <?php  
		 $counter=1;
		$i = 1;
		foreach ($res as $row) 
		{  
		?>
	<tr>	
	<td><?php echo $i++; ?></td>	
	<td><?php echo $row->mobile;?></td>  
	</tr>
	<?php 
		$counter++;}  
		?>  
</table>
</div>
</body>
</html>

