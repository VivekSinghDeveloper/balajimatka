<div class="page-content">
	<div class="container-fluid">
	   <div class="row">
		  <div class="col-sm-12 col-xl-12 col-md-12">
			 <div class="row">
				<div class="col-sm-12">
				   <div class="card">
					    <div class="card-body">
						<h4 class="card-title">Auto Deposit</h4>
						 <form class="theme-form mega-form" id="autoDepositeFrm" name="autoDepositeFrm" method="post" autocomplete="off">
							<div class="row">
							   <div class="form-group col-md-2">
								  <label>Date</label>
								  <?php $date = date('Y-m-d');?>
								  <div class="date-picker">
									 <div class="input-group">
										<input class="form-control digits" type="date" value="<?php echo $date;?>" name="bid_revert_date" id="bid_revert_date"  max="<?php echo $date;?>" >
									 </div>
								  </div>
							   </div>
							   <div class="form-group col-md-2">
									<label>&nbsp;</label>	
									<button type="submit" class="btn btn-primary btn-block" id="submitBtn" name="submitBtn">Submit</button>
								</div>
							</div>
							<div class="form-group">
							   <div id="error"></div>
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
				   <h4 class="card-title">Auto Deposit History</h4> 
					<div class="mt-3">
					  <table class="table table-striped table-bordered" id="autoDepositeTable">
						 <thead>
							<tr>
							   <th>#</th>
							   <th>User Name</th>
							   <th>Amount</th>
							   <th>Method</th>
							   <th>UPI</th>
							   <th>Txn Request No.</th>
							   <th>Txn ID</th>
							   <th>Txn Date</th>
							</tr>
						 </thead>
						 <tbody id="auto_deposite_data_1">

						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
</div>
