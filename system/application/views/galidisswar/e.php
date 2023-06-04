<div class="page-content">
<div class="container-fluid">

	<div class="row">

		<div class="col-12 col-sm-12 col-lg-12">

            <div class="row">

				<div class="col-sm-12 col-12 ">

                    <div class="card">


						<div class="card-body">
						<h5>Select Game</h5>
							<form class="theme-form mega-form" name="galidisswarGameSrchFrm" id="galidisswarGameSrchFrm" method="post">

	<input type="hidden" name="id" id="id">

							<div class="row">
                                
                                <div class="form-group col-md-2">
                                    
                                    <label>Result Date</label>
										<?php $date = date('Y-m-d');?>
										<div class="date-picker">
											<div class="input-group">
											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="result_dec_date" id="result_gali_dec_date" max="<?php echo $date;?>" >
											</div>
										</div>
								</div>
                                
								<div class="form-group col-md-4">

									<label>Game Name </label>

									<select class="form-control" name="game_id" id="game_id">
										<option value="">Select Name</option>

									<?php if(isset($game_result)){ 
									foreach($game_result as $rs){?>
										<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
									<?php }} ?>
									</select>

								</div>
								<div class="form-group">
								<label>&nbsp;</label>
									<button type="submit"  class="btn btn-primary btn-block" id="srchBtn" name="srchBtn">Go</button>

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
	
	
	
	<div class="row display_none" id="result_div" >
			<div class="col-12 col-sm-12 col-lg-12">
				<div class="row">
					<div class="col-sm-12 col-12 ">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Declare Result</h4>
								<div class="row open_panna_area">
									<div class="col-12 col-md-12">
										<div class="row">
											<div class="form-group col-md-4">
												<label>Numbers</label>
												<select class="form-control select2" name="open_number" id="open_number" data-placeholder="Select 2 Digit Value">
													   <option></option>
													   <?php if(isset($jodi_number)) { 
																foreach($jodi_number as $rs) { ?>
																<option value="<?php echo $rs->jodi_digit; ?>"><?php echo $rs->jodi_digit;?></option>
															<?php } } ?>
												 </select>
											</div>
											
											
											<div class="form-group col-md-4" id="open_div_msg">
											
											</div>
											
										</div>
									</div>
								</div>
								<div class="form-group">
									<div id="error2"></div>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row"> 
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Game Result History</h4>
						<div class="form-group row">
							<div class="col-md-3">
								<label>Select Result Date</label>
								<?php $date = date('Y-m-d');?>
								<div class="date-picker">
									<div class="input-group">
										<input class="form-control digits" type="date" name="result_date" id="result_date" value="<?php echo $date;?>" max="<?php echo $date;?>" >
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead> 
								<tr>
									<th>#</th>
									<th>Game Name</th>
									<th>Result Date</th>
									<th>Declare Date</th>
									<th>Number</th>
								</tr>
							</thead>
							<tbody id="getgalidisswarResultHistory">
							
							</tbody>
						</table>
					    </div>
				</div>
			</div>
		</div>
	</div>
	
</div>

    

</div>
<style>
.bord{padding: 15px;border: 1px solid black;}.select2-container {	width: 398.984px !important;}
</style>