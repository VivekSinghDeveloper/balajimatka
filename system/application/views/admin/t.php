<?php 
$panna_arr=explode(',','000,100,110,111,112,113,114,115,116,117,118,119,120,122,123,124,125,126,127,128,129,130,133,134,135,136,137,138,139,140,144,145,146,147,148,149,150,155,156,157,158,159,160,166,167,168,169,170,177,178,179,180,188,189,190,199,200,220,222,223,224,225,226,227,228,229,230,233,234,235,236,237,238,239,240,244,245,246,247,248,249,250,255,256,257,258,259,260,266,267,268,269,270,277,278,279,280,288,289,290,299,300,330,333,334,335,336,337,338,339,340,344,345,346,347,348,349,350,355,356,357,358,359,360,366,367,368,369,370,377,378,379,380,388,389,390,399,400,440,444,445,446,447,448,449,450,455,456,457,458,459,460,466,467,468,469,470,477,478,479,480,488,489,490,499,500,550,555,556,557,558,559,560,566,567,568,569,570,577,578,579,580,588,589,590,599,600,660,666,667,668,669,670,677,678,679,680,688,689,690,699,700,770,777,778,779,780,788,789,790,799,800,880,888,889,890,899,900,990,999');
?>

<div class="page-content">

	<div class="container-fluid">

		<div class="row">

			<div class="col-12 col-sm-12 col-lg-12">

				<div class="row">

					<div class="col-sm-12 col-12 ">

						<div class="card">

							<div class="card-body">
								<h4 class="card-title">Select Game</h4>
								<form name="gameSrchFrm" id="gameSrchFrm" method="post">

								<input type="hidden" name="id" id="id">

								<div class="row">
									<div class="form-group col-md-3">
										<?php $date = date('Y-m-d');?>
										<label>Result Date</label>

										<div class="date-picker">

											<div class="input-group">

											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="result_dec_date" id="result_dec_date" max="<?php echo $date;?>" >

											</div>

										</div>

									</div>
									
									<div class="form-group col-md-4">

										<label>Game Name </label>

										<select class="form-control" name="game_id" id="game_id">
											<option value="">Select Name</option>

										<?php if(isset($game_result)){ 
										foreach($game_result as $rs){ 
											if($rs->open_decleare_status==1 && $rs->close_decleare_status==1){
											    
											}else{
										?>
											<option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?> (<?php echo $rs->open_time.'-'.$rs->close_time;?>)</option>
											<?php }}} ?>
										</select>

									</div>
									
									
									<div class="form-group col-md-3">	
										<label>Session</label>		
										<select id="market_status" name="market_status" class="form-control">
											<option value="">-Select Session-</option>
												<option value="1">Open</option>
												<option value="2">Close</option>
												
										</select>	
									</div>
									
									<div class="form-group col-md-2">
										<label>&nbsp;</label>	
										<button type="submit" class="btn btn-primary btn-block" id="srchBtn" name="srchBtn">Go</button>
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
									<div class="mt-3" id="withdraw_data_details">
										<div class="bs_box bs_box_light_withdraw">
											<span>Open Result :-</span>
											<b><span id="open_result_data">0</span></b>
										</div>
									</div>
								<div class="row open_panna_area">
									<div class="col-12 col-md-12">
									
										<?php
										/* <h5 class="tit_h">Open</h5> */
										?>
										<div class="row">
											<div class="form-group col-md-4">
												<label>Panna</label>
												<select class="form-control getDigitOpenResult select2" name="open_number" id="open_number" data-placeholder="Select panna">
													<option></option>
												<?php for($p=0;$p<count($panna_arr);$p++){ ?>
													<option value="<?php echo $panna_arr[$p];?>"><?php echo $panna_arr[$p];?></option>
												<?php } ?>
												</select>
												
												<?php
												/* <input class="form-control" type="number" name="open_number" required id="open_number" value="" placeholder="Enter 3 Digit Value"> */
												?>
											</div>
											<div class="form-group col-md-4">
												<label>Digit</label>
												<input class="form-control" type="number" name="open_result" id="open_result" readonly >
											</div>
											
											<div class="form-group col-md-4" id="open_div_msg">
												<label>&nbsp;</label>
												<button type="button" class="btn btn-primary waves-light mr-1" id="openSaveBtn" name="openSaveBtn" onclick="OpenSaveData();">Save</button>

												<button type="button" class="btn btn-primary waves-light mr-1 display_none" id="openDecBtn" name="openDecBtn" onclick="decleareOpenResult();">Declare</button>
											</div>

										</div>
									
									</div>
								</div>
								
								
								<div class="row close_panna_area">
									<div class="col-12 col-md-12">
										<div class="row">
											
											<div class="form-group col-md-4">

												<label>Panna:</label>
												<select class="form-control select2 getDigitCloseResult" name="close_number" id="close_number" data-placeholder="Select panna">
													<option></option>
												<?php for($p=0;$p<count($panna_arr);$p++){ ?>
													<option value="<?php echo $panna_arr[$p];?>">
													    <?php echo $panna_arr[$p];?>
												</option>
												<?php } ?>
												</select>
												
												<?php
												/* <input class="form-control" type="number" name="close_number" id="close_number" required value="" placeholder="Enter 3 Digit Value"> */
												?>
											
											</div>
											<div class="form-group col-md-4">
												<label>Digit</label>
												<input class="form-control" type="number" name="close_result" id="close_result">
											</div>
											
											<div class="form-group col-md-4" id="close_div_msg">
												<label>&nbsp;</label>
												<button type="button"  class="btn btn-primary waves-light mr-1" id="closeSaveBtn" name="closeSaveBtn" onclick="closeSaveData();" readonly >Save</button>

												<button type="button" class="btn btn-primary waves-light mr-1 display_none" id="closeDecBtn" name="closeDecBtn" onclick="decleareCloseResult();">Declare</button>

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
										<input class="form-control digits" type="date" name="result_pik_date" id="result_pik_date" value="<?php echo $date;?>" max="<?php echo $date;?>" >
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
									<th>Open Declare Date</th>
									<th>Close Declare Date</th>
									<th>Open Pana</th>
									<th>Close Pana</th>
									
								</tr>
							</thead>
							<tbody id="getGameResultHistory">
							
							</tbody>
						</table>
					    </div>
				</div>
			</div>
		</div>
	</div>
	
	
	</div>
</div>

