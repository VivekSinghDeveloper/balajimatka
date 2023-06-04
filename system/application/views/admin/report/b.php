<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xl-12 col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-header p-t-15 p-b-15">
								<h5>Withdraw History Report</h5>
							</div>
							<div class="card-body">
								<form class="theme-form mega-form" id="withdrawReportFrm" name="withdrawReportFrm" method="post">
								<div class="row">
									<div class="form-group col-md-2">
										<label>Date</label>
										<?php $date = date('Y-m-d');?>
										<div class="date-picker">
											<div class="input-group">
											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="withdraw_date" id="withdraw_date" max="<?php echo $date;?>" >
											</div>
										</div>
									</div>
									<div class="form-group col-md-2">
										<label>&nbsp;</label>	
										<button type="submit" class="btn btn-primary btn-block" id="submitBtn" name="submitBtn">Submit</button>
									</div>
								</div>
									<div class="form-group">
										<div id="error_msg"></div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row"> 
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Withdraw List</h4>
						<div class="mt-3" id="withdraw_data_details">
							<div class="bs_box bs_box_light_withdraw">
								<i class="mdi mdi-wallet mr-1"></i> 
								<span>Total Withdraw Amount :-</span>
								<b><span id="t_withdraw_amt">0</span></b>
							</div>
							
							<div class="bs_box bs_box_light_accept">
								<i class="mdi mdi-wallet mr-1"></i> 
								<span>Total Accepted :-</span>
								<b><span id="t_accept_reqts">0</span></b>
							</div>
							<div class="bs_box bs_box_light_reject">
								<i class="mdi mdi-wallet mr-1"></i> 
								<span>Total Rejected :-</span>
								<b><span id="t_reject_reqts">0</span></b>
							</div>
						</div>
						<div class="mt-3 dt-ext table-responsive">
							<table id="withdrawList" class="table table-striped table-bordered">
								<thead> 
									<tr>
										<th>User Name</th>
										<th>Mobile</th>
										<th>Amount</th>
										<th>Payment Method</th>
										<th>Request No.</th>
										<th>Date</th>
										<th>Status</th>
										<th>View</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="withdraw_data">

								

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
