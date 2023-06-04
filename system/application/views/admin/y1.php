<div class="page-content">
	<div class="container-fluid">
		<div class="row"> 
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title mb-3">Main Market(<?php echo $this->cur_date2; ?>)</h4>
						<div class="row">
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Single Digit</h5>
                                        <h2 class="my-0"><?php echo $bidsingle; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Jodi Digit</h5>
                                        <h2 class="my-0"><?php echo $bidjodi; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Single Pana</h5>
                                        <h2 class="my-0"><?php echo $bidsinglepana; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Double Pana</h5>
                                        <h2 class="my-0"><?php echo $biddouble; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Tripple Pana</h5>
                                        <h2 class="my-0"><?php echo $bidtripple; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Half Sangam</h5>
                                        <h2 class="my-0"><?php echo $bidhalf; ?></h2 class="my-0">
                                    </div>
                                </div>
							</div>
							
							<div class="col-sm-3">
								<div class="card border border-primary">
                                    <div class="card-body text-center">
										<h5 class="text-primary">Full Sangam</h5>
                                        <h2 class="my-0"><?php echo $bidfull; ?></h2 class="my-0">
                                    </div>
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
						<h4 class="card-title mb-3">Main Market Report</h4>
						 <form class="theme-form mega-form" id="mainMarketFrm" name="mainMarketFrm" method="post">
							<div class="row">
							   <?php $date = date('Y-m-d');?>
							   <div class="form-group col-md-2">
								  <label>Start Date</label>
								  <div class="date-picker">
									 <div class="input-group">
										<input class="form-control digits" type="date" value="<?php echo $date;?>" name="start_date" id="start_date" max="<?php echo $date;?>" >
									 </div>
								  </div>
							   </div>
							   <div class="form-group col-md-2">
								  <label>End Date</label>
								  <div class="date-picker">
									 <div class="input-group">
										<input class="form-control digits" type="date" value="<?php echo $date;?>" name="end_date" id="end_date" max="<?php echo $date;?>" >
									 </div>
								  </div>
							   </div>
							   <div class="form-group col-md-2">
								  <label>Game Name</label>		
								  <select id="game_name" name="game_name" class="form-control">
									 <option value=''>-Select Game Name-</option>
									 <?php if(isset($game_result)){ 
										foreach($game_result as $rs){?>
									 <option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
									 <?php }} ?>
								  </select>
							   </div>
							   <div class="form-group col-md-2">
								  <label>Game Type</label>		
								  <select  id="game_type" name="game_type" class="form-control" onchange="getSession(this.value)">
									 <option value=''>-Select Game Type -</option>
									 <option value="Single Digit">Single Digit</option>
									 <option value="Jodi Digit">Jodi Digit</option>
									 <option value="Single Pana">Single Pana</option>
									 <option value="Double Pana">Double Pana
									 </option>
									 <option value="Triple Pana">Triple Pana</option>
								  </select>
							   </div>
							   <div class="form-group col-md-2 session_get">
								  <label>Market Time</label>		
								  <select id="market_status" name="market_status" class="form-control">
									 <option value=''>-Select Market Time-</option>
									 <option value="Open">Open Market</option>
									 <option value="Close">Close Market</option>
								  </select>
							   </div>
							   <div class="form-group col-md-2">
								  <label>Digit</label>		
								  <select id="digit" name="digit" class="form-control select_digit">
									 <option value="">Select Digit</option>
								  </select>
							   </div>
							   <div class="form-group col-md-2">
								  <button type="submit" class="btn btn-primary btn-block" id="submitBtn" name="submitBtn">Submit</button>
							   </div>
							</div>
							<div class="form-group">
							   <div id="msg"></div>
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
			<div class="col-sm-12">
				<div class="card">
				  <div class="card-body">
				 
					  <table class="table table-striped table-bordered" id="myTable">
						<thead>
						  <tr>
							<th>S.no</th>
							<th>Username</th>
							<th>Market Name</th>
							<th>Game Type</th>
							<th>Single Ank</th>
							<th>Pana</th>
							<th>Bid Prize</th>
							<th>Date</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody id="tabledata">
						</tbody>
						</table>
					
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<div class="modal fade" id="updatebidModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
		<div class="modal-content col-12 col-md-5">
			  <div class="modal-header">
				<h5 class="modal-title">Update Bid</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  </div>
			  <div class="modal-body modal_update_edibid">
			</div>
		</div>
	</div>
</div>