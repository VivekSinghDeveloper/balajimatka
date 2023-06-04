<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-xl-12 col-md-12">
            <div class="row">
				<div class="col-sm-12">
                    <div class="card">
						<div class="card-body">
						<h5>Bid History Report</h5>
							<form class="theme-form mega-form" id="getgalidisswarBidHistoryFrm" name="getgalidisswarBidHistoryFrm" method="post">
							<div class="row">
								<div class="form-group col-md-2">
									<label>Date</label>
										<?php $date = date('Y-m-d');?>
										<div class="date-picker">
											<div class="input-group">
											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="bid_date" id="bid_date" max="<?php echo $date;?>" >
											</div>
										</div>
								</div>
								<div class="form-group col-md-4">	
									<label>Game Name</label>		
									<select id="game_name" name="game_name" class="form-control">
										<option value=''>-Select Game Name-</option>
										<option value='all'>All Games</option>	
										<?php if(isset($game_result)){ 
											foreach($game_result as $rs){?>
											<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
											<?php }} ?>
									</select>	
								</div>
								<div class="form-group col-md-4">	
									<label>Game Type</label>		
									<select id="game_type" name="game_type" class="form-control">
										<option value=''>-Select Game Type-</option>	
										<option value='all'>All Type</option>	
										<option value='1'>Left Digit</option>	
										<option value='2'>Right Digit</option>	
										<option value='3'>Jodi Digit</option>	
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
<input type="hidden" id="bid_game_type">

<div class="container-fluid">
	<div class="row"> 
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Bid History List
				<?php	/*<button id='export_btn' class="btn btn-primary btn-sm btn-float m-r-5" onclick="getgalidisswarBidHistoryExcelData()">Export To Excel</button>*/?>
					</h4>
					<div class="dt-ext table-responsive">
						<table id="bidHistory" class="table table-striped table-bordered">
							<thead> 
								<tr>
									<th>User Name</th>
									<th>Bid TX ID</th>
									<th>Game Name</th>
									<th>Game Type</th>
									<th>Digit</th>
									<th>Points</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody id="bid_data">
						
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="updatebidhistoryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-3">
	  <div class="modal-header">
		<h5 class="modal-title">Update Bid</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body modal_update_edibidhistory">
		</div>
	</div>
   </div>
</div>
