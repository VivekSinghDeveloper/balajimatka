<div class="page-content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0 font-size-18">Dashboard</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div>

				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xl-4">
				<div class="card overflow-hidden">
					<div class="bg-soft-primary">
						<div class="row">
							<div class="col-7">
								<div class="text-primary p-3">
									<h5 class="text-primary">Welcome Back !</h5>
									<p>Admin Dashboard</p>
								</div>
							</div>
							<div class="col-5 align-self-end">
								<img src="<?php echo base_url();?>adminassets/images/profile-img.png" alt="" class="img-fluid">
							</div>
						</div>
					</div>
					<div class="card-body pt-0 dboard_pro_mht">
						<div class="row">
							<div class="col-sm-4">
								<div class="avatar-md profile-user-wid mb-4">
									<img src="<?php echo base_url();?>adminassets/images/users/avatar-1.jpg" alt="" class="img-thumbnail rounded-circle">
								</div>
								<h5 class="font-size-15 text-truncate">
								<?php if($this->session->userdata('adminid')){ echo $this->session->userdata('adminid'); }?>
								</h5>
								<p class="text-muted mb-0 text-truncate">Admin</p>
							</div>

							<div class="col-sm-8">
								<div class="pt-4">

									<div class="row">
										<div class="col-6">
										    <a href="<?php echo base_url().admin.'/un-approved-users-list';?>">
											<h5 class="font-size-15"><?php if(isset($totalUnapprovedUsers))echo $totalUnapprovedUsers; ?></h5>
											<p class="text-muted mb-0">Unapproved Users</p>
											</a>
										</div>
										<div class="col-6">
										    <a href="<?php echo base_url().admin.'/user-management';?>">
											<h5 class="font-size-15"><?php if(isset($totalApprovedUsers))echo $totalApprovedUsers; ?></h5>
											<p class="text-muted mb-0">Approved Users</p>
											</a>
										</div>
									</div>
									<?php
									/*<div class="mt-4">
										<a href="#" class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i class="mdi mdi-arrow-right ml-1"></i></a>
									</div>*/
									?>
								</div>
							</div>
						</div>
					</div>
				</div><?php if($this->session->userdata('admin_type') == 1) { ?>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title mb-4">Market Bid Details</h4>
						<div class="row">
							<div class="col-sm-12">
								<p class="text-muted">Game Name</p>
								<form id="getMarketBidFrm" name="getMarketBidFrm" method="post">
									<div class="form-group">
										<div class="input-group">
											<select id="game_name" name="game_name" class="form-control getMarketBid">
												<option value=''>-Select Game Name-</option>
												<?php if(isset($game_result)){ 
										foreach($game_result as $rs){ 
											if($rs->open_decleare_status==1 && $rs->close_decleare_status==1){
											    
											}else{
										?>
											<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?> (<?php echo $rs->open_time.'-'.$rs->close_time;?>)</option>
											<?php }}} ?>
											</select>
											<?php
											/*
											<div class="input-group-append">
												<button class="btn btn-primary" type="submit" id="submitBtn" name="submitBtn"><i class="mdi mdi-arrow-right ml-1"></i></button>
											</div>*/
											?>
										</div>
									</div>
								</form>
								
								<h3 id="bid_amt">N/A</h3>
								<p class="text-muted">Market Amount</p>
								
							</div>
							
						</div>
						
					</div>
				</div><?php } ?>
			</div>
			
			<div class="col-xl-8">
				<div class="row">
					<div class="col-md-4">
						<div class="card mini-stats-wid">
						     <a href="<?php echo base_url().admin.'/user-management';?>">
							<div class="card-body">
								<div class="media">
									<div class="media-body">
									   	<p class="text-muted font-weight-medium">Users</p>
										<h4 class="mb-0"><?php if(isset($totalUsers))echo $totalUsers; ?></h4>
									</div>

									<div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
										<span class="avatar-title">
											<i class="bx bx-user font-size-24"></i>
										</span>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card mini-stats-wid">						<?php if($this->session->userdata('admin_type') == 1) { ?>
						    <a href="<?php echo base_url().admin.'/game-name';?>">						<?php } ?>
							<div class="card-body">
								<div class="media">
									<div class="media-body">
										<p class="text-muted font-weight-medium">Games</p>
										<h4 class="mb-0"><?php if(isset($totalGames))echo $totalGames; ?></h4>
									</div>

									<div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
										<span class="avatar-title rounded-circle bg-primary">
											<i class="bx bx-archive-in font-size-24"></i>
										</span>
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="card mini-stats-wid">
							<div class="card-body">
								<div class="media">
									<div class="media-body">
										<p class="text-muted font-weight-medium">Bid Amount</p>
										<h4 class="mb-0"><?php if(isset($today_bid_amt))echo $today_bid_amt; ?></h4>
									</div>

									<div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
										<span class="avatar-title rounded-circle bg-primary">
											<i class="bx bx-purchase-tag-alt font-size-24"></i>
										</span>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php if($this->session->userdata('admin_type') == 1) { ?>
				<div class="card">
					<div class="card-body">
						<h4 class="card-title mb-4">Total Bids On Single Ank Of Date <?php echo date('d M Y');?></h4>
						<form id="searchBidFrm" name="searchBidFrm" method="post">
							<div class="row">
								<div class="form-group col-md-5">
									<label>Game Name</label>		
									<select id="bid_game_name" name="bid_game_name" class="form-control">
										<option value=''>-Select Game Name-</option>
										<?php if(isset($game_result)){ 
										foreach($game_result as $rs){ 
											if($rs->open_decleare_status==1 && $rs->close_decleare_status==1){
											    
											}else{
										?>
											<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?> (<?php echo $rs->open_time.'-'.$rs->close_time;?>)</option>
											<?php }}} ?>
										
									</select>
								</div>
								<div class="form-group col-md-5">
									<label>Market Time</label>		
									<select id="market_status" name="market_status" class="form-control">
										<option value=''>-Select Market Time-</option>
											<option value="1">Open Market</option>
											<option value="2">Close Market</option>
											
									</select>
								</div>
								<div class="form-group col-md-2">
									<label>&nbsp;</label>	
									<button type="submit" class="btn btn-primary btn-block" id="searchBtn" name="searchBtn">Get</button>
								</div>
								
							</div>
						</form>
					</div>	
				</div>	

				<div class="row">
					<div class="col-md-12">
						<div id="search">
							<div class="row-2_5 tot_bit_boxs">
								<?php for($i=0;$i<10;$i++){ ?>
								<div class="col-md-2_5">
									<div class="card border card_<?php echo $i;?>">
										<div class="card-header bg-transparent card_<?php echo $i;?>">
											<h5 class="my-0 text-primary">Total Bids <span id="bid<?php echo $i;?>">0</span></h5>
										</div>
										<div class="card-body">
											<h2 id="total<?php echo $i;?>">0</h2>
											<h5 class="card-title mt-0">Total Bid Amount</h5>
											
										</div>
										<div class="card-footer-ank">Ank <span><?php echo $i; ?></span></div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
<?php } ?>
				
			</div>
			
			
		</div>
	
	</div>


<div class="row">
			
			<div class="col-sm-12">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title">Fund Request Auto Deposit History</h4>
					<div class="dt-ext table-responsive demo-gallery">
					  <table class="table table-striped table-bordered " id="autoFundRequestList">
						<thead>
						  <tr>
							<th>#</th>
							<th>User Name</th>
							<th>Amount</th>
							<th>Request No.</th>
							<th>Txn Id</th>
							<th>Reject Remark</th>
							<th>Date</th>
							<th>Status</th>
							<th>Action</th>
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
</div>
</div>
