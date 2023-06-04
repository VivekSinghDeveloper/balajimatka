<div class="apage-content">

<div class="container-fluid"> 
	<div class="row">
	<!-- Zero Configuration  Starts-->
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
				<h4 class="card-title"><?php if(isset($banner_title2)) echo $banner_title2;?></h4>
				<form class="theme-form" id="walletReportFrm" name="walletReportFrm" method="post">
					<div class="row">
						<div class="form-group col-md-3">	
							<label>User Name</label>
							<select id="user_name" name="user_name" class="form-control">
								<option value="">Select User Name</option>
								 <?php if(isset($user_result)) {
									 foreach($user_result as $rs) {
										 
										 ?>
										 
										 
										 <option value="<?php echo $rs->user_id; ?>"><?php echo $rs->user_name; ?></option>
										 
										 
								 <?php }} ?>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label>From Date</label>
							<?php $date = date('Y-m-d');?>
							<div class="date-picker">
								<div class="input-group">
								  <input class="datepicker-here form-control digits" type="text" data-language="en" value="<?php echo $date;?>" name="from_date" id="from_date" placeholder="Select Date" data-position="bottom left">
								</div>
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>To Date</label>
							<?php $date = date('Y-m-d');?>
							<div class="date-picker">
								<div class="input-group">
								  <input class="datepicker-here form-control digits" type="text" data-language="en" value="<?php echo $date;?>" name="to_date" id="to_date" placeholder="Select Date" data-position="bottom left">
								</div>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label>&nbsp;</label>
							<button type="submit" class="btn btn-primary btn-block" id="submitBtn" name="submitBtn">Submit</button>
							<div id="cat_error"></div>
						</div>
					</div>
				</form>
			  </div>
			</div>
		</div>
		
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					 <h4 class="card-title">Report List</h4>
					 <div class="dt-ext table-responsive">
						<table id="myTable" class="table table-striped" id="basic-1">
							<thead>
								<tr>
									<th>#</th>
									<th>User Name</th>
									<th>Transaction Type</th>
									<th>Amount</th>
									<th>Amount Status</th>
									<th>Transaction Note</th>
									<th>Date</th>
									 
								</tr>
							</thead>
							<tbody id="wallet_report_list">
								
							</tbody>
						</table>
					 </div>
				</div>
			</div>
		</div>
		
	</div>
</div>
</div>