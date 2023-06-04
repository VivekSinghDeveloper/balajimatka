<?php 
$panna_arr=explode(',','000,100,110,111,112,113,114,115,116,117,118,119,120,122,123,124,125,126,127,128,129,130,133,134,135,136,137,138,139,140,144,145,146,147,148,149,150,155,156,157,158,159,160,166,167,168,169,170,177,178,179,180,188,189,190,199,200,220,222,223,224,225,226,227,228,229,230,233,234,235,236,237,238,239,240,244,245,246,247,248,249,250,255,256,257,258,259,260,266,267,268,269,270,277,278,279,280,288,289,290,299,300,330,333,334,335,336,337,338,339,340,344,345,346,347,348,349,350,355,356,357,358,359,360,366,367,368,369,370,377,378,379,380,388,389,390,399,400,440,444,445,446,447,448,449,450,455,456,457,458,459,460,466,467,468,469,470,477,478,479,480,488,489,490,499,500,550,555,556,557,558,559,560,566,567,568,569,570,577,578,579,580,588,589,590,599,600,660,666,667,668,669,670,677,678,679,680,688,689,690,699,700,770,777,778,779,780,788,789,790,799,800,880,888,889,890,899,900,990,999');
?>

<div class="page-content">
	<div class="container-fluid">
	   <div class="row">
		  <div class="col-sm-12 col-xl-12 col-md-12">
			 <div class="row">
				<div class="col-sm-12">
				   <div class="card">
					    <div class="card-body">
						<h4 class="card-title">Winning prediction</h4>
						
						 <form class="theme-form mega-form" id="geWinningpredictFrm" name="geWinningpredictFrm" method="post" autocomplete="off">
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
								  <select id="win_game_name" name="win_game_name" class="form-control" onchange="checkGameDeclare(this.value);">
									 <option value=''>-Select Game Name-</option>
									 <?php if(isset($game_result)){ 
										foreach($game_result as $rs){?>
									 <option value="<?php echo $rs->game_id;?>"><?php echo $rs->game_name;?></option>
									 <?php }} ?>
								  </select>
							   </div>
							   <div class="form-group col-md-2">
								  <label>Session Time</label>		
								  <select id="win_market_status" name="win_market_status" onchange="showclose(this.value);" class="form-control">
									 <option value=''>-Select Market Time-</option>
									 <option value="1">Open Market</option>
									 <option value="2">Close Market</option>
								  </select>
							   </div>
							   <div class="form-group col-md-2">	
								  <label>Open Pana</label>		
								  <select class="form-control select2" name="winning_ank" id="winning_ank" data-placeholder="Select open number">
								      <option></option>
									<?php for($p=0;$p<count($panna_arr);$p++){ ?>
										<option value="<?php echo $panna_arr[$p];?>"><?php echo $panna_arr[$p];?></option>
									<?php } ?>
									</select>
								  
							   </div>
							   <div class="form-group col-md-2" id="showclosediv" style="display:none;" >	
								  <label>Close Pana</label>		
								  <!--<input class="form-control" type="text"  value="" name="close_number" id="close_number" placeholder="Enter close number" >-->
									<select class="form-control select2" name="close_number" id="close_number" data-placeholder="Select close number">
											<option></option>
										<?php for($p=0;$p<count($panna_arr);$p++){ ?>
											<option value="<?php echo $panna_arr[$p];?>"><?php echo $panna_arr[$p];?></option>
										<?php } ?>
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
				   
					<div class="mt-3 table-responsive">
					  <table class="table table-striped table-bordered">
						 <thead>
							<tr>
							   <th>#</th>
							   <th>User Name</th>
							   <th>Bid Points</th>
							   <th>Winning Amount</th>
							   <th>Type</th>
							   <th>Bid TX ID</th>
							   <th>Action</th>
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