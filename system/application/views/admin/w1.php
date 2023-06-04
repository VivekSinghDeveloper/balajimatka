<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-xl-12 col-md-12">
            <div class="row">
				<div class="col-sm-12">
                    <div class="card">
						<div class="card-body">
						<h5>Bid History Report</h5>
							<form class="theme-form mega-form" id="getRouletteBidHistoryFrm" name="getRouletteBidHistoryFrm" method="post">
							<div class="row">
								<div class="form-group col-md-2">
									<label>Date</label>
									<?php $date = date('m/d/Y');?>
									<div class="date-picker">
										<div class="input-group">
										  <input class="datepicker-here form-control digits" type="text" data-language="en" value="<?php echo $date;?>" name="bid_date" id="bid_date" placeholder="Enter Batch Start Date" data-position="bottom left">
										</div>
									</div>
								</div>
								<div class="form-group col-md-4">	
									<label>Game Name</label>		
									<select id="game_name" name="game_name" class="form-control">
										<option value=''>-Select Game Name-</option>
										<option value='0'>All Games</option>	
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
									<div id="error_msg"></div>
								</div>
							</form>
						</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="bidHistory_date">
<input type="hidden" id="bid_game_name">


<div class="container-fluid">
	<div class="row"> 
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Bid History List
					<button id='export_btn' class="btn btn-primary btn-sm btn-float m-r-5" onclick="geRouletteBidHistoryExcelData()">Export To Excel</button>
					</h4>
					<div class="dt-ext table-responsive">
						<table id="bidHistory" class="table table-striped table-bordered">
							<thead> 
								<tr>
									<th>User Name</th>
									<th>Bid TX ID</th>
									<th>Game Name</th>
									<th>Digit</th>
									<th>Points</th>
								</tr>
							</thead>
							<tbody id="roulette_bid_data">
						
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>