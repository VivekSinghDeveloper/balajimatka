<div class="page-content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-12 col-xl-12 col-md-12">

				<div class="row">

					<div class="col-sm-12">

						<div class="card">

							<div class="card-header p-t-15 p-b-15">

								<h5>Winning History Report</h5>

							</div>

							<div class="card-body">

								<form class="theme-form mega-form" id="geWinningHistoryFrm" name="geWinningHistoryFrm" method="post">

								<div class="row">

									<div class="form-group col-md-2">

										<label>Date</label>

										<?php $date = date('Y-m-d');?>

										<div class="date-picker">

											<div class="input-group">

											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="result_date" id="result_date" max="<?php echo $date;?>" >

											</div>

										</div>

									</div>
										<div class="form-group col-md-4">	
										<label>Game Name</label>		
										<select id="win_game_name" name="win_game_name" class="form-control">
											<option value=''>-Select Game Name-</option>
											<?php if(isset($game_result)){ 
												foreach($game_result as $rs){?>
												<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
												<?php }} ?>
										</select>	
									</div>
									
									<div class="form-group col-md-4">	
										<label>Market Time</label>		
										<select id="win_market_status" name="win_market_status" class="form-control">
											<option value=''>-Select Market Time-</option>
												<option value="1">Open Market</option>
												<option value="2">Close Market</option>
												
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



	<input type="hidden" id="result_date">

	<input type="hidden" id="result_game_name">




	<div class="container-fluid">

		<div class="row"> 

			<div class="col-12">

				<div class="card">

					<div class="card-body">

						<h4 class="card-title">Winning History List</h4>

						<div class="dt-ext table-responsive">

							<table id="resultHistory" class="table table-striped table-bordered">

								<thead> 

									<tr>

										<th>User Name</th>

										

										<th>Game Name</th>
										<th>Game Type</th>
										<th>Open Pana</th>
										<th>Open digit</th>
										<th>Close Pana</th>
										<th>Close Digit</th>
										<th>Points</th>
										<th>Amount</th>
										<th>Tx Id</th>
										<th>Tx Date</th>

									</tr>

								</thead>

								<tbody id="result_data">

								

								</tbody>

							</table>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>
</div>

