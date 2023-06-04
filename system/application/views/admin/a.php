<div class="home-btn d-none d-sm-block">
	<a href="<?php echo base_url();?>" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
</div>
<div class="account-pages my-5 pt-sm-5">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 col-lg-6 col-xl-5">
				<div class="card overflow-hidden">
					<div class="bg-soft-primary">
						<div class="row">
							<div class="col-7">
								<div class="text-primary p-4">
									<h5 class="text-primary">Welcome Back !</h5>
									<p>Sign in to continue to Admin Console.</p>
								</div>
							</div>
							<div class="col-5 align-self-end">
								<img src="<?php echo base_url();?>adminassets/images/profile-img.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
					<div class="card-body pt-0"> 
						<div>
							<a href="#">
								<div class="avatar-md profile-user-wid mb-4">
									<span class="avatar-title rounded-circle bg-white">
										<img src="<?php echo base_url();?>adminassets/images/logo1.png" alt="" class="rounded-circle login_logo" >
									</span>
								</div>
							</a>
						</div>
						<div class="p-2">
							<form class="form-horizontal" method="post" id="loginform">

								<div class="form-group">
									<label for="username">Username</label>
									<input type="text" class="form-control" id="name" name="name" placeholder="Enter username">
								</div>
		
								<div class="form-group">
									<label for="userpassword">Password</label>
									<input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
								</div>
		
								
								<div class="mt-3">
									<button class="btn btn-primary btn-block waves-effect waves-light" type="submit" id="submitBtn">Log In</button>
								</div>
	
								<div class="mt-4 text-center">
								    <?php
								    /*
									<a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>*/
									?>
								</div>
							</form>
						</div>
	
					</div>
				</div>
				

			</div>
		</div>
	</div>
</div>