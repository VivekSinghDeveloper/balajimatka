<div class="page-content">
	<div class="container-fluid">
		<div class="row row_col">
			<div class="col-sm-12 col-xl-6">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title">Add Bank Details</h4>
						<form class="theme-form mega-form" id="adminsettingFrm" name="adminsettingFrm" method="post">
							<input type="hidden" name="account_id" value="<?php if(isset($id)){ echo $id; }?>">
							<div class="form-group">
								<label class="col-form-label">Account Holder Name</label>
								<input class="form-control" type="text" name="ac_name" id="ac_name" value="<?php if(isset($ac_holder_name)){ echo $ac_holder_name;}?>" placeholder="Enter Account Holder Name">
							</div>
							<div class="form-group">
								<label class="col-form-label">Account Number</label>
								<input class="form-control" type="Number" name="ac_number" id="ac_number" value="<?php if(isset($account_number)){ echo $account_number; }?>" placeholder="Enter Account Number">
							</div>
							<div class="form-group">
								<label class="col-form-label">IFSC Code</label>
								<input class="form-control" type="text" name="ifsc_code" id="ifsc_code"  value="<?php if(isset($ifsc_code)){ echo $ifsc_code; }?>" placeholder="Enter ">
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="buysubmitBtn">Submit</button>
							</div>
							<div class="form-group">
								<div id="error"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-xl-6">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title">Add App Link</h4>
						<form class="theme-form mega-form" id="appLinkFrm" name="appLinkFrm" method="post">
							<input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; }?>">
							<div class="form-group">
								<label class="col-form-label">App Link</label>
								<input class="form-control" type="text" name="app_link" id="app_link" value="<?php if(isset($app_link)){ echo $app_link;}?>" placeholder="Enter APP Link">
							</div>
							<div class="form-group">
								<label class="col-form-label">Share Message</label>
								<textarea class="form-control" name="content" rows="4" id="content"><?php if(isset($content)){ echo $content;}?></textarea>
							</div>
							<div class="form-group">
									<label class="col-form-label">Referral Share Message</label>
									<textarea class="form-control" name="share_referral_content" rows="4" id="share_referral_content"><?php if(isset($share_referral_content)){ echo $share_referral_content;}?></textarea>
								</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitMobileBtn">Submit</button>
							</div>
							<div class="form-group">
								<div id="error_msg"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-xl-6">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title">Add UPI ID</h4>
						<form class="theme-form mega-form" id="adminUPIFrm" name="adminUPIFrm" method="post">
							<input type="hidden" name="account_id" value="<?php if(isset($id)){ echo $id; }?>">
							
							
							<div class="row">
								<div class="form-group col-12">
									<label class="col-form-label">Google UPI Payment Id</label>
									<input class="form-control" type="text" name="google_upi_payment_id" id="google_upi_payment_id"  value="<?php if(isset($google_upi_payment_id)){ echo $google_upi_payment_id; }?>" placeholder="Enter google upi payment id">
								</div>
							</div>
							
							<div class="row">
								<div class="form-group col-12">
									<label class="col-form-label">Phone Pe UPI Payment Id</label>
									<input class="form-control" type="text" name="phonepay_upi_payment_id" id="phonepay_upi_payment_id"  value="<?php if(isset($phonepay_upi_payment_id)){ echo $phonepay_upi_payment_id; }?>" placeholder="Enter phonepay upi payment id">
								</div>
							</div>
							
							<div class="row">
								<div class="form-group col-12">
									<label class="col-form-label">Other UPI Payment Id</label>
									<input class="form-control" type="text" name="upi_payment_id" id="upi_payment_id"  value="<?php if(isset($upi_payment_id)){ echo $upi_payment_id; }?>" placeholder="Enter upi payment id">
								</div>
							</div>
							
							<div class="form-group">
								<button type="submit" class="btn btn-primary waves-light m-t-10" id="upiSubmitBtn" name="upiSubmitBtn">Submit</button>
							</div>
							<div class="form-group">
								<div id="error_upi"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-12 col-xl-6">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title">App Maintainence</h4>
						<form class="theme-form mega-form" id="appMaintainenceFrm" name="appMaintainenceFrm" method="post">
							<input type="hidden" name="value_id" value="<?php if(isset($value_id)){ echo $value_id; }?>">
							<div class="form-group">
								<label class="col-form-label">Share Message</label>
								<textarea class="form-control" name="app_maintainence_msg" rows="4" id="app_maintainence_msg"><?php if(isset($app_maintainence_msg)){ echo $app_maintainence_msg;}?></textarea>
							</div>
							<div class="form-group col-6" style="margin-top:30px;">
								<div class="media">
									 <div class="custom-control custom-switch mb-3" dir="ltr">
										<input type="checkbox" class="custom-control-input" id="maintainence_msg_status" name="maintainence_msg_status" <?php if(isset($maintainence_msg_status) && $maintainence_msg_status==1){ echo 'checked'; } ?> value="1">
										<label class="custom-control-label" for="maintainence_msg_status">Show Msg (ON/OFF)</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtnAppMaintainece" name="submitBtnAppMaintainece">Submit</button>
							</div>
							<div class="form-group">
								<div id="error_maintainence"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="col-sm-12 col-xl-6">
				<div class="card h100p">
					<div class="card-body">
						<h4 class="card-title">Add Referral Bonus Details</h4>
						
						<form class="theme-form mega-form" id="referralBonusSettingFrm" name="referralBonusSettingFrm" method="post">
								<input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; }?>">
								<div class="form-group">
									<label class="col-form-label">Referral First Bonus Percentage</label>
									<input class="form-control" type="text" name="referral_first_bonus" id="referral_first_bonus" value="<?php if(isset($referral_first_bonus)){ echo $referral_first_bonus;}?>" placeholder="Enter Referral First Bonus Percentage">
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Referral First Bonus Max Amount</label>
									<input class="form-control" type="text" name="referral_first_bonus_max" id="referral_first_bonus_max" value="<?php if(isset($referral_first_bonus_max)){ echo $referral_first_bonus_max;}?>" placeholder="Enter Referral First Bonus Max Amount">
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Referral Remaining Bonus Percentage</label>
									<input class="form-control" type="text" name="referral_second_bonus" id="referral_second_bonus" value="<?php if(isset($referral_second_bonus)){ echo $referral_second_bonus;}?>" placeholder="Enter Referral First Bonus Percentage">
								</div>
								
								<div class="form-group">
									<label class="col-form-label">Referral Remaining Bonus Max Amount</label>
									<input class="form-control" type="text" name="referral_second_bonus_max" id="referral_second_bonus_max" value="<?php if(isset($referral_first_bonus)){ echo $referral_second_bonus_max;}?>" placeholder="Enter Referral Second Bonus Percentage">
								</div>
								
								<div class="form-group">
									<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="buysubmitBtn">Submit</button>
								</div>
								<div class="form-group">
									<div id="error_ref"></div>
								</div>
							</form>
						
						</div>
				</div>
			</div>
		
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xl-12">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-xl-12">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Add Value's</h4>
								<form class="theme-form mega-form" id="adminvaluesettingFrm" name="adminvaluesettingFrm" method="post">
									<input type="hidden" name="value_id" value="<?php if(isset($value_id)){ echo $value_id; }?>">
								<div class="row">
									<div class="form-group col-md-4">
										<label class="col-form-label">Minimum Deposite</label>
										<input class="form-control" type="number" min=0 name="min_deposite" id="min_deposite" value="<?php if(isset($min_deposite)){ echo $min_deposite;}?>" placeholder="Enter Min. Deposite Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Maximum Deposite</label>
										<input class="form-control" type="number" min=0 name="max_deposite" id="max_deposite" value="<?php if(isset($max_deposite)){ echo $max_deposite; }?>" placeholder="Enter Max Deposite Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Minimum Withdrawal</label>
										<input class="form-control" type="number" min=0 name="min_withdrawal" id="min_withdrawal"  value="<?php if(isset($min_withdrawal)){ echo $min_withdrawal; }?>" placeholder="Enter Min Withdrawal Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Maximum Withdrawal</label>
										<input class="form-control" type="number" min=0 name="max_withdrawal" id="max_withdrawal"  value="<?php if(isset($max_withdrawal)){ echo $max_withdrawal; }?>" placeholder="Enter Max Withdrawal Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Minimum Transfer</label>
										<input class="form-control" type="number" min=0 name="min_transfer" id="min_transfer"  value="<?php if(isset($min_transfer)){ echo $min_transfer; }?>" placeholder="Enter Min Transfer Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Maximum Transfer</label>
										<input class="form-control" type="number" min=0 name="max_transfer" id="max_transfer"  value="<?php if(isset($max_transfer)){ echo $max_transfer; }?>" placeholder="Enter Max Transfer Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Minimum Bid Amount</label>
										<input class="form-control" type="number" min=0 name="min_bid_amt" id="min_bid_amt"  value="<?php if(isset($min_bid_amt)){ echo $min_bid_amt; }?>" placeholder="Enter Min Bid Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Maximum Bid Amount</label>
										<input class="form-control" type="number" min=0 name="max_bid_amt" id="max_bid_amt"  value="<?php if(isset($max_bid_amt)){ echo $max_bid_amt; }?>" placeholder="Enter Max Bid Amount">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label">Welcome Bonus</label>
										<input class="form-control" type="number" min=0 name="welcome_bonus" id="welcome_bonus"  value="<?php if(isset($welcome_bonus)){ echo $welcome_bonus; }?>" placeholder="Enter Welcome Bonus Amount">
									</div>
								</div>
								<div class="row">
									<div class="form-group col-2">
												<label  for="open_time">Withdraw Open Time</label>

												  <input name="withdraw_open_time" id="withdraw_open_time" class="form-control digits" value="<?php  echo $withdraw_open_time; ?>" type="time" >
												
									</div>
									<div class="form-group col-2">
												<label for="close_time">Withdraw Close Time</label>
												  <input name="withdraw_close_time" id="withdraw_close_time" class="form-control digits" type="time" value="<?php if(isset($withdraw_close_time)){ echo $withdraw_close_time; } ?>">
												
									</div>
									<div class="form-group col-2" style="margin-top:30px;">
												
												<div class="media">
												
												 <div class="custom-control custom-switch mb-3" dir="ltr">
													<input type="checkbox" class="custom-control-input" id="global_batting_status" name="global_batting_status" <?php if(isset($global_batting_status) && $global_batting_status==1){ echo 'checked'; } ?> value="1">
													<label class="custom-control-label" for="global_batting_status">Global Batting</label>
												</div>
											
											  </div>
												
												
								   </div>
								   </div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitValueBtn" name="submitValueBtn">Submit</button>
									</div>
									<div class="form-group">
										<div id="alert"></div>
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


<div class="modal fade" id="upiUpdateModal" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog modal-frame modal-top modal-md">
	<div class="modal-content">
	<div class="modal-header">
	<h5 class="modal-title">UPI Update</h5>
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
  </div>
	  <div class="modal-body">
		<form class="theme-form mega-form" id="UPIOTPConfirmFrm" name="UPIOTPConfirmFrm" method="post">
			<input type="hidden" name="account_id" value="<?php if(isset($id)){ echo $id; }?>">
			<input type="hidden" name="upi_id" id="upi_id" value="">
			<input type="hidden" name="up_google_upi_payment_id" id="up_google_upi_payment_id" value="">
			<input type="hidden" name="up_phonepay_upi_payment_id" id="up_phonepay_upi_payment_id" value="">
			<div class="form-group">
				<h6 id="otp_number">OTP Sent To :- <?php echo $mobile; ?></h6>
			</div>
			<div class="form-group">
				<label class="col-form-label">OTP Code</label>
				<input class="form-control" type="text" name="otp_code" id="otp_code"  value="" placeholder="Enter OTP">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary waves-light m-t-10" id="otpSubmitBtn" name="otpSubmitBtn">Submit</button>
			</div>
			<div class="form-group">
				<div id="error_upi_otp"></div>
			</div>
		</form>
	  </div>
	</div>
  </div>
</div>

