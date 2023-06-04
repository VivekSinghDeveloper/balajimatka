<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="ccol-12 col-lg-8 mr-auto ml-auto">
            <div class="row">
				<div class="col-sm-12 col-12 ">
                    <div class="card">

						<div class="card-body">
							<h4 class="card-title">Add Games Rate</h4>
							<form class="theme-form mega-form" id="galidisswarGameRatesFrm" name="galidisswarGameRatesFrm" method="post">
								<input type="hidden" name="game_rate_id" value="<?php if(isset($game_rate_id)){ echo $game_rate_id; }?>">
							<div class="row">
								<div class="form-group col-md-6">
									<label class="col-form-label">Single Digit Value 1</label>
									<input class="form-control" type="number" name="single_digit_1" id="single_digit_1" value="<?php if(isset($single_digit_val_1)){ echo $single_digit_val_1;}?>" placeholder="Enter Single Digit Value">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label">Single Digit Value 2</label>
									<input class="form-control" type="number" name="single_digit_2" id="single_digit_2" value="<?php if(isset($single_digit_val_2)){ echo $single_digit_val_2;}?>" placeholder="Enter Single Digit Value">
								</div>
								
								<div class="form-group col-md-6">
									<label class="col-form-label">Single Pana Value 1</label>
									<input class="form-control" type="number" name="single_pana_1" id="single_pana_1" value="<?php if(isset($single_pana_val_1)){ echo $single_pana_val_1;}?>" placeholder="Enter Single Pana Value">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label">Single Pana Value 2</label>
									<input class="form-control" type="number" name="single_pana_2" id="single_pana_2" value="<?php if(isset($single_pana_val_2)){ echo $single_pana_val_2;}?>" placeholder="Enter Single Pana Value">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label">Double Pana Value 1</label>
									<input class="form-control" type="number" name="double_pana_1" id="double_pana_1" value="<?php if(isset($double_pana_val_1)){ echo $double_pana_val_1;}?>" placeholder="Enter Double Pana Value">
								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label">Double Pana Value 2</label>
									<input class="form-control" type="number" name="double_pana_2" id="double_pana_2" value="<?php if(isset($double_pana_val_2)){ echo $double_pana_val_2;}?>" placeholder="Enter Double Pana Value">
								</div>
							
								
								
							</div>	
								<div class="form-group">
									<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="buysubmitBtn">Submit</button>
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
</div>