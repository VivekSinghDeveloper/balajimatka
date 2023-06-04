<div class="page-content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0 font-size-18"><?php if(isset($banner_title2)) echo $banner_title2;?></h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active"><?php if(isset($banner_title2)) echo $banner_title2;?></li>
						</ol>
					</div>

				</div>
			</div>
		</div>
		
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title d-flex align-items-center justify-content-between">&nbsp; <a href="<?php echo base_url().admin.'/un-approved-users-list';?>" class="btn btn-primary waves-effect waves-light btn-sm">Un-approved Users List</a></h4>
					<div class="table-responsive">
					<table id="userList" class="table table-bordered">
						<thead>
						  <tr>
							<th>#</th>
							<th>User Name</th>
							<th>Mobile</th>
							<th>email</th>
							<th>Date</th>
							<th>Balance</th>
							<th>Betting</th>
							<th>Transfer</th>
							<th>Active</th>
							<th>View</th>
						  </tr>
						</thead>
					</table>
					<div id="msg"></div>
				</div>
				</div>
			</div>
		</div>
		
		
	</div>
</div>