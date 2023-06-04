<header id="page-topbar">
	<div class="navbar-header">
		<div class="d-flex">
			<!-- LOGO -->
			<div class="navbar-brand-box">
				<a href="<?php echo base_url();?>" class="logo logo-dark">
					<span class="logo-sm">
						<img src="<?php echo base_url();?>adminassets/images/logo1.png" alt="" height="22">
					</span>
					<span class="logo-lg">
						<img src="<?php echo base_url();?>adminassets/images/logo2.png" alt="" height="17">
					</span>
				</a>

				<a href="<?php echo base_url();?>" class="logo logo-light">
					<span class="logo-sm">
						<img src="<?php echo base_url();?>adminassets/images/logo1.png" alt="" height="22">
					</span>
					<span class="logo-lg">
						<img src="<?php echo base_url();?>adminassets/images/logo2.png" alt="" height="19">
					</span>
				</a>
			</div>

			<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
				<i class="fa fa-fw fa-bars"></i>
			</button>
			
			<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
				<b><a href="<?php echo base_url().admin;?>">Home</a></b>
			</button>

	
		</div>

		<div class="d-flex">
			
			
			<div class="dropdown d-none d-lg-inline-block ml-1">
				<button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
					<i class="bx bx-fullscreen"></i>
				</button>
			</div>

			
			<div class="dropdown d-inline-block">
				<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="rounded-circle header-profile-user" src="<?php echo base_url();?>adminassets/images/users/avatar-1.jpg"
						alt="Header Avatar">
					<span class="d-none d-xl-inline-block ml-1" key="t-henry">Admin</span>
					<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					<!-- item-->
					<a class="dropdown-item" href="<?php echo base_url().admin.'/change-password';?>"><i class="bx bx-user font-size-16 align-middle mr-1"></i> <span key="t-lock-screen">Change Password</span></a>
					<a class="dropdown-item d-block" href="<?php echo base_url().admin.'/main-settings';?>"><i class="bx bx-wrench font-size-16 align-middle mr-1"></i> <span key="t-settings">Settings</span></a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item text-danger" href="#logoutModal" data-toggle="modal"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> <span key="t-logout">Logout</span></a>
				</div>
			</div>

			

		</div>
	</div>
</header>

<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

	<div data-simplebar class="h-100">

		<!--- Sidemenu -->
		<div id="sidebar-menu">
			<!-- Left Menu Start -->
			<ul class="metismenu list-unstyled" id="side-menu">
				<li>
					<a href="<?php echo base_url().admin.'/dashboard';?>" class="waves-effect mm-active">
						<i class="bx bx-home-circle"></i>
						<span>Dashboard</span>
					</a>
				</li>	
			
				<li>
					<a href="<?php echo base_url().admin.'/user-management';?>" class="waves-effect">
						<i class="bx bxs-user-detail"></i>
						<span>User Management</span>
					</a>
				</li>
				
				<li>
					<a href="<?php echo base_url().admin.'/declare-result';?>" class="waves-effect">
						<i class="bx bx-bullseye"></i>
						<span>Declare Result</span>
					</a>
				</li>
				
				<li>
					<a href="<?php echo base_url().admin.'/winning-prediction';?>" class="waves-effect">
						<i class="bx bx-bullseye"></i>
						<span>Winning Prediction</span>
					</a>
				</li>
				
			<?php if($this->session->userdata('admin_type') == 1) { ?>
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-file"></i>
						<span>Report Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/user-bid-history';?>">Users Bid History</a></li>
						<li><a href="<?php echo base_url().admin.'/customer-sell-report';?>">Customer Sell Report</a></li>
						<li><a href="<?php echo base_url().admin.'/winning-report';?>">Winning Report</a></li>
						<li><a href="<?php echo base_url().admin.'/transfer-point-report';?>">Transfer Point Report</a></li>
						<li><a href="<?php echo base_url().admin.'/bid-winning-report';?>">Bid Win Report</a></li>
						<li><a href="<?php echo base_url().admin.'/withdraw-report';?>">Withdraw Report</a></li>
						<li><a href="<?php echo base_url().admin.'/auto-deposite-history';?>">Auto Deposit History</a> </li>
						 <li><a href="<?php echo base_url().admin.'/get-referral-amount-data';?>">Referral History</a> </li>
					</ul>
				</li>
			<?php } ?>
			
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-wallet"></i>
						<span>Wallet Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/fund-request-management';?>">Fund Request</a> </li>
						<li><a href="<?php echo base_url().admin.'/withdraw-request-management';?>">Withdraw Request</a> </li> 
						<li><a href="<?php echo base_url().admin.'/add-fund-user-wallet-management';?>">Add Fund (User Wallet)</a> </li>
						<li><a href="<?php echo base_url().admin.'/bid-revert';?>">Bid Revert</a> </li>
					</ul>
				</li>
			<?php if($this->session->userdata('admin_type') == 1) { ?>
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-bullseye"></i>
						<span>Games Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/game-name';?>">Game Name</a> </li>
						<li><a href="<?php echo base_url().admin.'/game-rates';?>">Game Rates</a></li>
					</ul>
				</li>
			<?php } ?>	
				
			<?php if($this->session->userdata('admin_type') == 1) { ?>	
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-bullseye"></i>
						<span>Game & Numbers</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/single-digit';?>">Single Digit</a></li>
				  
						<li><a href="<?php echo base_url().admin.'/jodi-digit';?>">Jodi Digit</a> </li> 
						
						<li><a href="<?php echo base_url().admin.'/single-pana';?>">Single Pana</a> </li> 
					   
						<li><a href="<?php echo base_url().admin.'/double-pana';?>">Double Pana</a> </li> 
					   
						<li><a href="<?php echo base_url().admin.'/tripple-pana';?>">Tripple Pana</a> </li> 
						
						<li><a href="<?php echo base_url().admin.'/half-sangam';?>">Half Sangam</a> </li> 
					   
						<li><a href="<?php echo base_url().admin.'/full-sangam';?>">Full Sangam</a> </li>  
					</ul>
				</li>
				
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-cog"></i>
						<span>Settings</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/main-settings';?>">Main Settings</a></li>
						<li><a href="<?php echo base_url().admin.'/contact-settings';?>">Contact Settings</a></li>
						<li><a href="<?php echo base_url().admin.'/clear-data';?>">Clear Data</a></li>
						<li><a href="<?php echo base_url().admin.'/slider-images-management';?>">Slider Images</a></li>
						<li><a href="<?php echo base_url().admin.'/how-to-play';?>">How To Play</a> </li>
					</ul>
				</li>
			<?php } ?>	
				<?php /* 
				<li>
					<a href="<?php echo base_url().admin.'/slider-images-management';?>" class="waves-effect">
						<i class="bx bxs-user-detail"></i>
						<span>Slider Images</span>
					</a>
				</li>
				
				<li>
					<a href="<?php echo base_url().admin.'/clear-data';?>" class="waves-effect">
						<i class="bx bx-archive-in"></i>
						<span>Clear Data</span>
					</a>
				</li> */ ?>
				
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-cog"></i>
						<span>Notice Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/notice-management';?>">Notice Management</a> </li>
						<li><a href="<?php echo base_url().admin.'/send-notification';?>">Send Notification</a> </li> 
					</ul>
				</li>
				
				<?php /*
				
				 <li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-file"></i>
						<span>Starline Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/starline-game-name';?>">Game Name</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-game-rates';?>">Game Rates</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-user-bid-history';?>">Bid History</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-decleare-result';?>">Decleare Result</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-result-history';?>">Result History</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-sell-report';?>">Starline Sell report</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-winning-report';?>">Starline Winning report</a></li>
						<li><a href="<?php echo base_url().admin.'/starline-winning-prediction';?>">Starline Winning Prediction</a></li>
					</ul>
				</li>
				
				<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-file"></i>
						<span>Gali Disswar</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/galidisswar-game-name';?>">Game Name</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-game-rates';?>">Game Rates</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-user-bid-history';?>">Bid History</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-decleare-result';?>">Decleare Result</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-result-history';?>">Result History</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-sell-report';?>">Sell Report</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-winning-report';?>">Winning Report</a></li>
						<li><a href="<?php echo base_url().admin.'/galidisswar-winning-prediction';?>">Winning Prediction</a></li>
					</ul>
				</li> 
				*/ ?>
			<?php if($this->session->userdata('admin_type') == 1) { ?>	
				<li>
					<a href="<?php echo base_url().admin.'/users-querys';?>" class="waves-effect">
						<i class="bx bxs-user-detail"></i>
						<span>Users Query</span>
					</a>
				</li>
				
				<?php /* 
				<li>
					<a href="<?php echo base_url().admin.'/tips-management';?>" class="waves-effect">
						<i class="bx bxs-user-detail"></i>
						<span>Tips Management</span>
					</a>
				</li> */?>
				 
				<li>
					<a href="<?php echo base_url().admin.'/sub-admin-management';?>" class="waves-effect">
						<i class="bx bxs-user-detail"></i>
						<span>Sub Admin Management</span>
					</a>
				</li>
			<?php } ?>
			<?php /*<li>
					<a href="javascript: void(0);" class="has-arrow waves-effect">
						<i class="bx bx-file"></i>
						<span>Roulette Management</span>
					</a>
					<ul class="sub-menu mm-collapse" aria-expanded="false">
						<li><a href="<?php echo base_url().admin.'/roulette-game-name';?>">Game Name</a></li>
						<li><a href="<?php echo base_url().admin.'/roulette-bid-history';?>">Bid History</a></li>
						<li><a href="<?php echo base_url().admin.'/roulette-result-history';?>">Result History</a></li>
						<li><a href="<?php echo base_url().admin.'/roulette-winning-report';?>">Roulette Winning Report</a></li>
					</ul>
				</li> */ ?>
				
			</ul>
		</div>
		<!-- Sidebar -->
	</div>
</div>
<!-- Left Sidebar End -->

<div class="main-content">