 
<div class="page-content">
	<div class="container-fluid">
	   <div class="row">
		  <div class="col-sm-12 col-xl-12 col-md-12">
			 <div class="row">
				<div class="col-sm-12">
				   <div class="card">
					    <div class="card-body">
						<h4 class="card-title">Winning prediction</h4>
						
						 <form class="theme-form mega-form" id="galidissawarWinningpredictFrm" name="galidissawarWinningpredictFrm" method="post" autocomplete="off">
							<div class="row">
							   <div class="form-group col-md-2">
								  <label>Date</label>
								  <?php $date = date('Y-m-d');?>
								  <div class="date-picker">
									 <div class="input-group">
										<input class="form-control digits" type="date" value="<?php echo $date;?>" name="result_date" id="result_date"  max="<?php echo $date;?>" >
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
								  <label>Number</label>		
								  <select id="winning_ank" name="winning_ank" class="form-control select2">
									 <option value=''>-Select Number-</option>
									 <?php if(isset($jodi_data)){ 
										foreach($jodi_data as $rs){?>
									 <option value="<?php echo $rs->jodi_digit;?>"><?php echo $rs->jodi_digit;?></option>
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
				   <h4 class="card-title">Winning Prediction List
				   </h4>
					<div class="mt-3">
						<div class="bs_box bs_box_light">
							<i class="mdi mdi-gavel mr-1"></i> 
							<span>Total Bid Amount</span>
							<b><span id="t_bid">0</span></b>
						</div>
						
						<div class="bs_box bs_box_light">
							<i class="mdi mdi-wallet mr-1"></i> 
							<span>Total Winning Amount</span>
							<b><span id="t_winneing_amt">0</span></b>
						</div>
					</div>
				   
					<div class="mt-3">
					  <table class="table table-striped table-bordered">
						 <thead>
							<tr>
							   <th>#</th>
							   <th>User Name</th>
							   <th>Bid Points</th>
							   <th>Winning Amount</th>
							   <th>Type</th>
							   <th>Bid TX ID</th>
							</tr>
						 </thead>
						 <tbody id="winner_result_data">
						 </tbody>
					  </table>
				   </div>
				</div>
			 </div>
		  </div>
	   </div>
	</div>
	
</div>