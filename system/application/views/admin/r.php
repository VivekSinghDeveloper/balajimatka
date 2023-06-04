<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12 col-xl-12">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-xl-12">
						<div class="card">
						  <div class="card-header">
							<h5>Contact Settings</h5>
						  </div>
							<div class="card-body">
								<form class="theme-form mega-form" id="adminContactFrm" name="adminContactFrm" method="post">
									<input type="hidden" name="id" value="<?php if(isset($id)){ echo $id; }?>">
								<div class="row">
									<div class="form-group col-md-4">
										<label class="col-form-label"><strong>Mobile Number <span class="Img_ext">eg.9876543210</span></strong></label>
										<input type="text" class="form-control mobile-valid" name="mobile_1" id="mobile_1" placeholder="Please Enter Mobile Number" value="<?php if(isset($mobile_1)){ echo $mobile_1; }?>">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label"><strong>Telegram Mobile (Optional)</strong></label>
										<input type="text" class="form-control" name="mobile_2" id="mobile_2" placeholder="Please Enter Second Mobile Number" value="<?php if(isset($mobile_2)){ echo $mobile_2; }?>">
									</div>
									<div class="form-group col-md-4">
										<label class="col-form-label"><strong>WhatsApp Number</strong></label>
										<input type="text" class="form-control" name="whats_mobile" id="whats_mobile" placeholder="Please Enter WhatsApp Mobile Number" value="<?php if(isset($whatsapp_no)){ echo $whatsapp_no; }?>">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Landline 1 (Optional) <span class="Img_ext">eg.0141-9999999</span></strong></label>
										<input class="form-control" type="number" min=0 name="landline_1" id="landline_1"  value="<?php if(isset($landline_1)){ echo $landline_1; }?>" placeholder="Enter Landline Number">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Landline 2 (Optional)</strong></label>
										<input class="form-control" type="number" min=0 name="landline_2" id="landline_2"  value="<?php if(isset($landline_2)){ echo $landline_2; }?>" placeholder="Enter Second Landline Number">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Email 1</strong></label>
										<input class="form-control" type="text" name="email_1" id="email_1"  value="<?php if(isset($email_1)){ echo $email_1; }?>" placeholder="Enter Email">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Email 2 (Optional)</strong></label>
										<input class="form-control" type="text" name="email_2" id="email_2"  value="<?php if(isset($email_2)){ echo $email_2; }?>" placeholder="Enter Email">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Facebook (Optional)</strong></label>
										<input class="form-control" type="text" name="facebook" id="facebook"  value="<?php if(isset($facebook)){ echo $facebook; }?>" placeholder="Enter Facebook Link">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Twitter (Optional)</strong></label>
										<input class="form-control" type="text" name="twitter" id="twitter"  value="<?php if(isset($twitter)){ echo $twitter; }?>" placeholder="Enter Twitter Link">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Youtube (Optional)</strong></label>
										<input class="form-control" type="text" name="youtube" id="youtube"  value="<?php if(isset($youtube)){ echo $youtube; }?>" placeholder="Enter Youtube Link">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Google Plus (Optional)</strong></label>
										<input class="form-control" type="text" name="google_plus" id="google_plus"  value="<?php if(isset($google_plus)){ echo $google_plus; }?>" placeholder="Enter Google Plus Link">
									</div>
									<div class="form-group col-md-6">
										<label class="col-form-label"><strong>Instagram (Optional)</strong></label>
										<input class="form-control" type="text" name="instagram" id="instagram"  value="<?php if(isset($instagram)){ echo $instagram; }?>" placeholder="Enter Instagram Link">
									</div>
									<div class="form-group col-md-3">
										<label class="col-form-label"><strong>Latitude</strong></label>
										<input class="form-control" type="text" name="latitude" id="latitude"  value="<?php if(isset($latitude)){ echo $latitude; }?>" placeholder="Enter Latitude">
									</div>
									<div class="form-group col-md-3">
										<label class="col-form-label"><strong>Longitude</strong></label>
										<input class="form-control" type="text" name="longitude" id="longitude"  value="<?php if(isset($logitude)){ echo $logitude; }?>" placeholder="Enter Longitude">
									</div>
									<div class="form-group col-md-12">
										<label class="col-form-label"><strong>Address</strong></label>
										<textarea class="form-control" name='address' id='address'><?php if(isset($address)){ echo $address; }?></textarea>
									</div>
								</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
									</div>
									<div class="form-group">
										<div id="errormsg"></div>
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