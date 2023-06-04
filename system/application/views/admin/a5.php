<div class="page-content">
	<div class="container-fluid">
	   <div class="row">
		  <div class="col-sm-12 col-xl-12 col-md-12">
			 <div class="row">
				<div class="col-sm-12">
				   <div class="card">
					    <div class="card-body">
						<h4 class="card-title">Bid Revert</h4>
						
						 <form class="theme-form mega-form" id="bidRevertFrm" name="bidRevertFrm" method="post" autocomplete="off">
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
								  <label>Game Name</label>		
								  <select id="win_game_name" name="win_game_name" class="form-control">
									 <option value=''>-Select Game Name-</option>
									 <?php if(isset($game_result)){ 
										foreach($game_result as $rs){?>
									 <option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
									 <?php }} ?>
								  </select>
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
				   <h4 class="card-title">Bid Revert List
				     <a class="btn btn-primary btn-sm btn-float clear_btn" href="#revertModel" role="button" data-toggle="modal">Clear & Refund All</a> 
				   </h4> 
					<div class="mt-3">
					  <table class="table table-striped table-bordered" id="bidRevertTable">
						 <thead>
							<tr>
							   <th>#</th>
							   <th>User Name</th>
							   <th>Bid Points</th>
							   <th>Type</th>
							</tr>
						 </thead>
						 <tbody id="bid_result_data">
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
	
</div>


<div class="modal fade" id="revertModel" tabindex="-1" role="dialog" aria-hidden="true" >
  <div class="modal-dialog modal-frame modal-top modal-md">
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	  <span aria-hidden="true">&times;</span>
	</button>
  </div>
	  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-left">
						<h5>Are you sure you want to clean and refund bid amount...?</h5>
					</div>
					<div class="col-md-4 text-left">
						<button onclick="data_refund()" id="data_clean_date" class="btn btn-danger waves-effect waves-light">Yes</button>
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
					</div>
					<div class="error_msg">
				</div>
			</div>
	  </div>
	</div>
  </div>
</div>


