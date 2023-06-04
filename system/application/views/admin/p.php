<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-lg-6 mr-auto ml-auto">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Add Balance In User Wallet</h4>
								<form id="balanceAddFrm" name="balanceAddFrm" method="post">
									<div class="form-group">
										<label>User List</label>
										<select id="user" name="user" class="form-control  select2 show_parent" >
											<option value="">Select User</option>
											<?php if(isset($user_data)) { 
												foreach($user_data as $rs) { ?>
											<option value="<?php echo $rs->user_id; ?>" data-user_name="<?php echo $rs->user_name;?>" data-mobile="<?php echo $rs->mobile;?>" data-wallet_balance="<?php echo $rs->wallet_balance;?>"><?php echo $rs->user_name.'('.$rs->mobile.')'; ?></option>
											<?php } } ?>
										</select>	
									</div>
									<div class="form-group">
										<label>Amount</label>
										<input class="form-control" type="Number" min=0 name="amount" id="amount" placeholder="Enter Amount">
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn">Submit</button>
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
</div>

<div id="paymentApprovalModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Confirmation</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="paymentApprovalFrm" method="post" enctype="multipart/formdata">
		
		<div class="userInfo"></div>
		<h6>Are you sure you want to transfer amount to this user.</h6>
		<input type="hidden" id="user_id" name="user_id" value="">
		<input type="hidden" id="user_amount" name="user_amount" value="">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-primary btn-sm m-t-10" id="approvedPayment">Yes</button>
		  <button type="submit" class="btn btn-danger btn-sm m-t-10" id="rejectPayment">No</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="alert_msg"></div>
		  </div>
	   </form>
      </div>
    </div>
  </div>
</div>