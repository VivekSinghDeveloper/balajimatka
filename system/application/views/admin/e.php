<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0 font-size-18">User Details</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">User Management</a></li>
							<li class="breadcrumb-item active">User Details</li>
						</ol>
					</div>

				</div>
			</div>
		</div>
		
		<div class="row row_col">
			<div class="col-xl-4">
				<div class="card overflow-hidden h100p">
					<div class="bg-soft-primary">
						<div class="row">
							<div class="col-7">
								<div class="text-primary p-3">
									<h5 class="text-primary"><?php if(isset($user_name)){ echo $user_name; } ?></h5>
									<p><?php if(isset($mobile)){ echo $mobile; } ?>
									<?php if(isset($mobile) && $mobile!=0 && $mobile!=""){?>
									<a href="tel:91<?php echo $mobile;?>"><i class="mdi mdi-cellphone-iphone"></i></a>
									<a href="https://wa.me/91<?php echo $mobile;?>" target="blank"><i class="mdi mdi-whatsapp"></i></a>
									<?php } ?>
									</p>
								</div>
							</div>
							<div class="col-5 align-center">
								<div class="p-3 text-right">
									<div class="mb-2">
									Active:
									<?php if(isset($status) && $status == 1 ) { ?>
										<a role="button" class="activeDeactiveStatus" id="<?php echo 'success-'.$user_id.'-tb_user-user_id-status';?>"><span class="badge badge-pill badge-success font-size-12">Yes</span></a>
									<?php } else { ?>
										<a role="button" class="activeDeactiveStatus" id="<?php echo 'danger-'.$user_id.'-tb_user-user_id-status';?>"><span class="badge badge-pill badge-danger font-size-12">No</span></a>									
									<?php }?>
									</div>
									<div class="mb-2">
										Betting: 
										<?php if(isset($betting_status) && $betting_status==1) { ?>
											<a role="button" class="activeDeactiveStatus" id="<?php echo 'success-'.$user_id.'-tb_user-user_id-betting_status';?>"><span class="badge badge-pill badge-success font-size-12">Yes</span></a>
										<?php } else { ?>
											<a role="button" class="activeDeactiveStatus" id="<?php echo 'danger-'.$user_id.'-tb_user-user_id-betting_status';?>"><span class="badge badge-pill badge-danger font-size-12">No</span></a>
										<?php } ?>
									</div>
									
									<div class="mb-2">
										TP: 
										<?php if(isset($transfer_point_status) && $transfer_point_status==1) { ?>
											<a role="button" class="activeDeactiveStatus" id="<?php echo 'success-'.$user_id.'-tb_user-user_id-transfer_point_status';?>"><span class="badge badge-pill badge-success font-size-12" >Yes</span></a>
										<?php } else { ?>
											<a role="button" class="activeDeactiveStatus" id="<?php echo 'danger-'.$user_id.'-tb_user-user_id-transfer_point_status';?>"><span class="badge badge-pill badge-danger font-size-12">No</span></a>	
										<?php } ?>
									</div>
									
									<div class="mb-2">
										Logout Status: 
											<a role="button" onClick="changeLogoutStatus(<?php echo $user_id;?>);"><span class="badge badge-pill badge-success font-size-12" >Logout Now</span></a>
										
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="card-body pt-0">
						<div class="row">
							<div class="col-sm-4">
								<div class="avatar-md profile-user-wid mb-4">
									<img src="<?php echo base_url();?>adminassets/images/user.png" alt="" class="img-thumbnail rounded-circle">
								</div>
								
							</div>

							<div class="col-sm-8">
								<div class="pt-4">
								   
									<div class="row">
										<div class="col-6">
											<p class="text-muted mb-0">Security Pin</p>
											<h5 class="font-size-15 mb-0"><?php if(isset($security_pin)){ echo $security_pin; } ?></h5>
										</div>
										<div class="col-6">
											<button class="btn btn-primary btn-sm" id="changePin">Change</button>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>
					<div class="card-body border-top">
                                        
						<div class="row">
							<div class="col-sm-12">
								<div>
									<p class="text-muted mb-2">Available Balance</p>
									<h5><?php if(isset($wallet_balance)){ echo $wallet_balance; } ?></h5>
								</div>
								
							</div>
							
							<div class="col-sm-6">
								<div class="mt-3">
									<button class="btn btn-success btn-sm w-md btn-block" id="adFund">Add Fund</button>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mt-3">
									<button class="btn btn-danger btn-sm w-md btn-block" id="withdrawFund">Withdraw Fund</button>
								</div>
							</div>
						</div>
					</div>
					
					
				</div>
			</div>
			
			<div class="col-xl-8">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title mb-4">Personal Information</h4>
						<div class="table-responsive">
							<table class="table table-nowrap mb-0">
								<tbody>
									<tr>
										<th scope="row">Full Name :</th>
										<td><?php if(isset($user_name)){ echo $user_name; } ?></td>
										<th scope="row">Email :</th>
										<td><?php if(isset($email) && $email!=""){ echo $email; } else { echo 'N/A'; } ?></td>
									</tr>
									<tr>
										<th scope="row">Mobile :</th>
										<td><?php if(isset($mobile)){ echo $mobile; } ?>
											<?php if(isset($mobile) && $mobile!=0 && $mobile!=""){?>
											<a href="tel:91<?php echo $mobile;?>"><i class="mdi mdi-cellphone-iphone"></i></a>
											<a href="https://wa.me/91<?php echo $mobile;?>" target="blank"><i class="mdi mdi-whatsapp"></i></a>
											<?php } ?>
										
										</td>
										<th scope="row">Password :</th>
										<td><?php if(isset($password)){ echo $password; } ?></td>
									</tr>
									<tr>
										<th scope="row">District Name :</th>
										<td><?php if(isset($district_name) && $district_name!=""){ echo $district_name; } else { echo 'N/A'; } ?></td>
										<th scope="row">Flat/Plot No. :</th>
										<td><?php if(isset($flat_ploat_no) && $flat_ploat_no!=""){ echo $flat_ploat_no; } else { echo 'N/A'; } ?></td>
									</tr>
									<tr>
										<th scope="row">Address Lane 1 :</th>
										<td><?php if(isset($address_lane_1) && $address_lane_1!=""){ echo $address_lane_1; } else { echo 'N/A'; } ?></td>
										<th scope="row">Address Lane 2 :</th>
										<td><?php if(isset($address_lane_2) && $address_lane_2!=""){ echo $address_lane_2; } else { echo 'N/A'; } ?></td>
									</tr>
									<tr>
										<th scope="row">Area :</th>
										<td><?php if(isset($area) && $area!=""){ echo $area; } else { echo 'N/A'; } ?></td>
										<th scope="row">Pin Code :</th>
										<td><?php if(isset($pin_code) && $pin_code!=""){ echo $pin_code; } else { echo 'N/A'; } ?></td>
									</tr>
									<tr>
										<th scope="row">State Name :</th>
										<td><?php if(isset($state_name) && $state_name!=""){ echo $state_name; } else { echo 'N/A'; } ?></td>
										<th scope="row"></th>
										<td></td>
									</tr>
									<tr>
										<th scope="row">Creation Date :</th>
										<td><?php if(isset($insert_date)){ echo $insert_date; } ?></td>
										<th scope="row">Last Seen :</th>
										<td><?php if(isset($last_update) && $last_update!=""){ echo $last_update; } else { echo 'N/A'; } ?></td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-xl-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title mb-4">Payment Information</h4>
						<div class="table-responsive">
							<table class="table table-nowrap mb-0">
								<tbody>
									<tr>
										<th scope="row">Bank Name :</th>
										<td><?php if(isset($bank_name) && $bank_name!=""){ echo $bank_name; } else { echo 'N/A'; } ?></td>
										<th scope="row">Branch Address :</th>
										<td><?php if(isset($branch_address) && $branch_address!=""){ echo $branch_address; } else { echo 'N/A'; } ?></td>
										<th scope="row"></th>
										<td></td>
										
									</tr>
									<tr>
										<th scope="row">A/c Holder Name :</th>
										<td><?php if(isset($ac_holder_name) && $ac_holder_name!=""){ echo $ac_holder_name; } else { echo 'N/A'; } ?></td>
										<th scope="row">A/c Number :</th>
										<td><?php if(isset($ac_number) && $ac_number!=""){ echo $ac_number; } else { echo 'N/A'; } ?></td>
										<th scope="row">IFSC Code :</th>
										<td><?php if(isset($ifsc_code) && $ifsc_code!=""){ echo $ifsc_code; } else { echo 'N/A'; } ?></td>
										
									</tr>
									<tr>
										<th scope="row">PhonePe No. :</th>
										<td><?php if(isset($phone_pay_number) && $phone_pay_number!=""){ echo $phone_pay_number; } else { echo 'N/A'; } ?></td>
										<th scope="row">Google Pay No. :</th>
										<td><?php if(isset($google_pay_number) && $google_pay_number!=""){ echo $google_pay_number; } else { echo 'N/A'; } ?></td>
										<th scope="row">Paytm No. :</th>
										<td><?php if(isset($paytm_number) && $paytm_number!=""){ echo $paytm_number; } else { echo 'N/A'; } ?></td>
										
									</tr>
								</tbody>
							</table>
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
						<h4 class="card-title">Add Fund Request List</h4>
						<div class="demo-gallery">
							<table id="myTable" class="table table-striped table-bordered  list-unstyled">
								<thead> 
									<tr>
										<th>#</th>
										<th>Request Amount</th>
										<th>Request	No.</th>
										<th>Receipt Image</th>
										<th>Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php if(isset($fundrequestData)) {
									$i=1;	foreach($fundrequestData as $rs) { ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $rs->request_amount; ?></td>
										<td><?php echo $rs->request_number; ?></td>
										<td><?php if($rs->fund_payment_receipt) { ?>
										<li>
											<a class="item" href="<?php echo base_url();?>uploads/file/<?php echo $rs->fund_payment_receipt; ?>">
											<img src="<?php echo base_url();?>uploads/file/<?php echo $rs->fund_payment_receipt; ?>" width="30">
											</a>
										</li>
										<?php } else { echo "N/A"; } ?>
										</td>
										<td><?php echo $rs->insert_date; ?></td>
										<td id="status<?php echo $rs->fund_request_id; ?>"><?php if($rs->request_status == 0 ){ echo '<badge class="badge badge-info">Pending</badge>'; } else if($rs->request_status == 1 ) { echo '<badge class="badge badge-danger">Rejected</badge>';}else { echo '<badge class="badge badge-success">Accepted</badge>'; }?></td>
										<td><?php if($rs->request_status == 1 || $rs->request_status == 2) { ?>
											<a href="javascript:void(0);" data-id=""><button class="btn btn-outline-primary btn-xs m-l-5" type="button" disabled >Accept</button></a>

											<a href="javascript:void(0);" data-id=""><button class="btn btn-outline-danger btn-xs m-l-5" type="button" disabled >Reject</button></a>
										<?php } else { ?>
											<a title="Accept" href="javascript:void(0);" class="openPopupAcceptRequest" data-id="<?php echo $rs->fund_request_id;?>"><button class="btn btn-outline-primary btn-xs m-l-5" id="accept" type="button" title="Accept">Accept</button></a>

											<a title="Reject" href="javascript:void(0);" class="openPopupRejectRequest" data-id="<?php echo $rs->fund_request_id;?>"><button class="btn btn-outline-danger btn-xs m-l-5" id="reject" type="button" title="Reject">Reject</button></a>
										<?php } ?>
										</td>
									</tr>
								<?php $i++; } }?>
								</tbody>
							</table>
						</div>
						<div id="msg"></div>
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
						<h4 class="card-title">Withdraw Fund Request List</h4>
						<div class="demo-gallery">
							<table id="withdrawTable" class="table table-striped table-bordered list-unstyled">
								<thead> 
									<tr>
										<th>#</th>
										<th>Request Amount</th>
										<th>Request	No.</th>
										<th>Request Date</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php if(isset($withdrawrequestData)) {
									$i=1;	foreach($withdrawrequestData as $rs) { ?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $rs->request_amount; ?></td>
										<td><?php echo $rs->request_number; ?></td>
										
										<td><?php echo $rs->insert_date; ?></td>
										<td id="status<?php echo $rs->withdraw_request_id; ?>"><?php if($rs->request_status == 0 ){ echo '<badge class="badge badge-info">Pending</badge>'; } else if($rs->request_status == 1 ) { echo '<badge class="badge badge-danger">Rejected</badge>';}else { echo '<badge class="badge badge-success">Accepted</badge>'; }?></td>
										<td><a data-href="<?php echo base_url().admin.'/view-withdraw-request/'.$rs->withdraw_request_id;?>" class="openViewWithdrawRequest"><button class="btn btn-outline-info btn-xs m-l-5" type="button">View</button></a></td>
									</tr>
								<?php $i++; } }?>
								</tbody>
							</table>
						</div>
						<div id="msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" id="user_id" value="<?php if(isset($user_id)){ echo $user_id; } ?>">
	
	<div class="container-fluid">
		<div class="row"> 
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Bid History</h4>
						<div class="">
							<table id="bidHistoryTable" class="table table-striped table-bordered">
								<thead> 
									<tr>
										<th>#</th>
										<th>Game Name</th>
										<th>Game Type</th>
										<th>Session</th>
										<th>Digits</th>
										<th>Close Digits</th>
										<th>Points</th>
										<th>Date</th>
									</tr>
								</thead>
							</table>
						</div>
						<div id="msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xl-12 xl-100">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Wallet Transaction History</h4>
						<ul class="nav nav-tabs nav-tabs-custom nav-justified" id="top-tab" role="tablist">
							<li class="nav-item"><a class="nav-link active" id="top-allr-tab" data-toggle="tab" href="#top-allr" role="tab" aria-controls="top-allr" aria-selected="true">All</a></li>
							<li class="nav-item"><a class="nav-link" id="inr-top-tab" data-toggle="tab" href="#top-inr" role="tab" aria-controls="top-inr" aria-selected="false">Credit</a></li>
							<li class="nav-item"><a class="nav-link" id="outr-top-tab" data-toggle="tab" href="#top-outr" role="tab" aria-controls="top-outr" aria-selected="false">Debit</a></li>
						</ul>
						<div class="tab-content p-3" id="top-tabContent">
							<div class="tab-pane fade show active" id="top-allr" role="tabpanel" aria-labelledby="top-allr-tab">
								<div class="">
									<table id="allTransactionTable" class="table table-striped table-bordered">
										<thead>
											<tr> 
												<th>#</th>
												<th>Amount</th>
												<th>Transaction Note</th>
												<th>Transfer Note</th>
												<th>Date</th>
												<th>Tx Req. No.</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="top-inr" role="tabpanel" aria-labelledby="inr-top-tab">
								<div class="">
									<table id="inTransactionTable" class="table table-striped table-bordered" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th>Amount</th>
												<th>Transaction Note</th>
												<th>Transfer Note</th>
												<th>Date</th>
												<th>Tx Req. No.</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="top-outr" role="tabpanel" aria-labelledby="outr-top-tab">
								<div class="">
									<table id="outTransactionTable" class="table table-striped table-bordered" style="width: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th>Amount</th>
												<th>Transaction Note</th>
												<th>Transfer Note</th>
												<th>Date</th>
												<th>Tx Req. No.</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xl-12 col-md-12">
				<div class="row">
					<div class="col-sm-12">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Winning History Report</h4>
								<form class="theme-form mega-form" id="userWinningHistoryFrm" name="userWinningHistoryFrm" method="post">
									<div class="row">
										<div class="form-group col-md-3">
											<label>Date</label>
											<?php $date = date('Y-m-d');?>
											<div class="date-picker">
												<div class="input-group">
												  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="result_date" id="result_date">
												</div>
											</div>
										</div>
										<input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id)) echo $user_id;?>">
										<div class="form-group col-md-2">
											<label>&nbsp;</label>
											<button type="submit" class="btn btn-primary waves-light btn-block" id="submitBtn_2" name="submitBtn_2">Submit</button>
										</div>
									</div>
									<div class="form-group">
										<div id="error_msg"></div>
									</div>
									<input type="hidden" id="result_date">
									<input type="hidden" id="result_game_name">
								</form>
								
								<table id="resultHistory" class="table table-striped table-bordered">
									<thead> 
										<tr>
											<th>Amount(<?php echo '&#x20b9'; ?>)</th>
											<th>Game Name</th>
											<th>Tx Id</th>
											<th>Tx Date</th>
										</tr>
									</thead>
									<tbody id="result_data">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	
</div>




<div class="modal fade" id="bettingAllowedModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog modal-frame modal-top modal-md">
	<div class="modal-content">
	  <div class="modal-body">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Are you sure you want to allowed betting for this user.</p>
				</div>
				<div class="col-md-12">
				<form class="theme-form"  id="bettingAllowedFrm" method="post" enctype="multipart/formdata">
					<input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id)) echo $user_id;?>">
				<div class="form-group">	
					<button class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-info waves-effect waves-light" id="submitBtn">Yes</button>
				</div>
				</form>
				<div class="form-group m-b-0">
					 <div id="alert"></div>
				  </div>
				</div>
			</div>
		</div>
	  </div>
	</div>
  </div>
</div>

<div id="addFundModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Fund</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="addFundFrm" method="post" enctype="multipart/formdata">
											
			  <div class="form-group">
				<label class="col-form-label">Amount</label>
				<input class="form-control" type="Number" min="0" name="user_amount" id="user_amount" placeholder="Enter Amount" data-original-title="" title="">
			</div>
		  <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id)) echo $user_id;?>">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-info btn-sm m-t-10" id="submitAddBtn" name="submitBtn">Submit</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="alert_msg"></div>
		  </div>
	   </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

<div id="changePinModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Pin</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="changePinFrm" method="post" enctype="multipart/formdata">
											
			  <div class="form-group">
				<label class="col-form-label">Enter New Pin</label>
				<input class="form-control digit_number" type="number" name="security_pin" id="security_pin" placeholder="Enter Security Pin" min="0" max="9999" maxlength="4">
			</div>
		  <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id)) echo $user_id;?>">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-info btn-sm m-t-10" id="submitchangepinBtn" name="submitchangepinBtn">Submit</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="alert_msg"></div>
		  </div>
	   </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>




<div id="withdrawFundModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Withdraw Fund</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="withdrawFundFrm" method="post" enctype="multipart/formdata">
											
			  <div class="form-group">
				<label class="col-form-label">Amount</label>
				<input class="form-control" type="Number" min="0" name="amount" id="amount" placeholder="Enter Amount" data-original-title="" title="">
			</div>
		  <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id)) echo $user_id;?>">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-info btn-sm m-t-10" id="submitWithdrawBtn" name="submitBtn">Submit</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="with_error_msg"></div>
		  </div>
	   </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>



<div id="viewWithdrawRequest" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myLargeModalLabel">Withdraw Request Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body viewWithdrawRequestBody">
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>