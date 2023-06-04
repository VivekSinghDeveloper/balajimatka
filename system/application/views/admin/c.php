<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-6 col-md-6 mr-auto ml-auto">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Change Password</h4>
						<form id="updatepass" name="updatepass" method="post" >
							
							<div class="form-group">
								<label for="exampleInputEmail1">Old Password</label>
								<input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Enter Old Password">
							</div>
							<div class="form-group">
									<label for="">New Password</label>
									<input name="newpass" class="form-control" id="newpass" type="password" placeholder="Enter New Password">
							</div>
							<div class="form-group">
									<label for="">Confirm Password</label>
								   <input class="form-control" name="retypepass" id="retypepass" type="password" placeholder="Enter Confirm Password"/>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary waves-effect waves-light m-t-10" id="submitBtn" name="submitBtn">Update Password</button>
							
							</div>
							<div class="form-group m-b-0">
								 <div id="updatepassmsg"></div>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>