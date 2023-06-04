<div class="container-fluid">
	<div class="row">
	
		<div class="col-12">
			<div class="card shadow-0 border">
				<div class="card-header align">
					<h5>Question Details</h5>
				</div>
				<div class="card-body packaging-card">
					<div class="table-responsive">
						<table class="table table-striped hght" id="basic-1">
							<thead>
								<tr>
									<th>Name</th>
									<th>Details</th>
									<th>Name</th>
									<th>Details</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Question</td>
									<td><?php if(isset($ques_title)){ echo $ques_title; } ?></td>
									<td>Answer</td>
									<td><?php if(isset($ques_ans)){ echo $ques_ans; } ?></td>
								</tr>
								<tr>
									<td>Creation Date</td>
									<td><?php if(isset($insert_date)){ echo $insert_date; }?></td>
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