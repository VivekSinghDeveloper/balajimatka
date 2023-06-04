 <div class="page-content">
 <div class="container-fluid">

	<div class="row">

		<div class="col-sm-12 col-xl-12 col-md-12">

            <div class="row">

				<div class="col-sm-12">

                    <div class="card">

						<div class="card-header p-t-15 p-b-15">

							<h5>Starline Sell Report</h5>

						</div>

						<div class="card-body">

							<form class="theme-form mega-form" id="starlineSellFrm" name="starlineSellFrm" method="post">

							<div class="row">
								<?php $date = date('m/d/Y');?>
								<div class="form-group col-md-2">

                                    <label>Date</label>
										<?php $date = date('Y-m-d');?>
										<div class="date-picker">
											<div class="input-group">
											  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="start_date" id="start_date" max="<?php echo $date;?>" >
											</div>
								<!--<label>Date</label>

									<div class="date-picker">

										<div class="input-group">

										  <input class="datepicker-here form-control digits" type="text" data-language="en" value="<?php echo $date;?>" name="start_date" id="start_date" placeholder="Enter Start Date" data-position="bottom left">

										</div>-->

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
									<select  id="game_type" name="game_type" class="form-control" onchange="getSession(this.value);">
										<option value='0'>All</option>
											<option value="Single Digit">Single Digit</option>
											<option value="Single Pana">Single Pana</option>
												<option value="Double Pana">Double Pana
											</option>
											<option value="Triple Pana">Triple Pana</option>
											 
									</select>	
								</div>
								
								
								
								<input type="hidden" name="market_status" id="market_status" value="Open">
								 
								
								<div class="form-group col-md-2">
									<label>&nbsp;</label>
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
	<!-- Zero Configuration  Starts-->	
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			 
				 <div class="mytable">
				 </div>
				 
				
				</div>
			</div>
		</div>
	</div>
</div>
 
 
 </div>