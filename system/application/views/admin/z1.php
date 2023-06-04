<div class="container-fluid">	
	<div class="row row_col">	
		<div class="col-6">		
			<div class="card">	
				<div class="card-body">	
					<h4 class="card-title">Tips Detail</h4>		
					<div class="table-responsive m-t-40">	
						<table class="table table-bordered table-striped">
							<thead>						
								<tr>					
									<th class="w-25">Name</th>
									<th>Details</th> 		
									<th class="w-25">Name</th>
									<th>Details</th> 			
								</tr>
							</thead>
							<tbody>		
								<tr>	
									<td>Tips Title</td>
									<td><?php if(isset($tips_title)){ echo $tips_title; } ?></td>						
									<td>Banner Image</td>
									<td><?php if(isset($banner_image) && $banner_image != '') { ?><img src="<?php echo base_url().'/uploads/file/'.$banner_image;?>" width="50"><?php } else { echo 'N/A'; } ?></td>				
								</tr>
								<tr>	
									<td>Description</td>
									<td colspan='3'><?php if(isset($description)){ echo $description; } ?></td>
								</tr>
								<tr>	
									<td>Creation date</td>
									<td><?php if(isset($insert_date)){ echo $insert_date; } ?></td>	
									<td></td>
									<td></td>						
								</tr>
							</tbody>
						</table>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>