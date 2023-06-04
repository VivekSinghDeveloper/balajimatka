<div class="page-content">
	<div class="container-fluid">
		<div class="row">
		<!-- Zero Configuration  Starts-->	
			<div class="col-sm-12">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title d-flex align-items-center justify-content-between"><?php if(isset($banner_title2)) echo $banner_title2;?>
				  <a class="btn btn-primary btn-sm btn-float" href="#addgameModal" role="button" data-toggle="modal">Add Game </a></h4>
					
					  <table class="table table-striped table-bordered" id="gameList">
						<thead>
						  <tr>
							<th>#</th>
							<th>Game Name</th>
							<th>Game Name Hindi</th>
							<th>Today Open</th>
							<th>Today Close</th>
							<th>Active</th>
							<th>Market Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						</table>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addgameModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Add Game</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form class="theme-form" id="addgameFrm" name="addgameFrm" method="post" >
			<div class="row">
				<input type="hidden" name="game_id" value="">
				<div class="form-group col-12">
					<label for="game_name">Game Name</label>
					<input type="text" name="game_name" id="game_name" class="form-control" placeholder="Enter Game Name"/>
				</div>
				
				<div class="form-group col-12">
					<label for="game_name_hindi">Game Name Hindi</label>
					<input type="text" name="game_name_hindi" id="game_name_hindi" class="form-control" placeholder="Enter Game Name In Hindi"/>
				</div>
				
				<div class="form-group col-6">
                            <label  for="open_time">Open Time</label>
                              <input name="open_time" id="open_time" class="form-control digits" type="time" value="">
                            
                </div>
                <div class="form-group col-6">
                            <label for="close_time">Close Time</label>
                              <input name="close_time" id="close_time" class="form-control digits" type="time" value="">
                            
                </div>
               
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light mr-1" id="submitBtn" name="submitBtn">Submit</button>
					<button type="reset" class="btn btn-danger waves-light mr-1">Reset</button>
				
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

<div class="modal fade" id="updategameModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Update Game</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body modal_update_game_body">
</div>
</div>
</div>
</div>

<div class="modal fade" id="offdayModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-xl-4">
	  <div class="modal-header">
		<h5 class="modal-title">Market Off Day</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body modal_off_day">
</div>
</div>
</div>
</div>

