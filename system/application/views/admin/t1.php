<div class="page-content">
<div class="container-fluid">
	<div class="row">
	<!-- Zero Configuration  Starts-->	
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			  <h4 class="card-title d-flex align-items-center justify-content-between"><?php if(isset($banner_title2)) echo $banner_title2;?>
			   <a class="btn btn-primary btn-sm btn-float openPopupAddRouletteGame" href="javascript:void(0);" data-href="<?php echo base_url().admin.'/add-roulette-game/0' ; ?>" role="button" data-toggle="modal">Add Game</a></h4>
				 
				  <table class="table table-striped table-bordered" id="gameRouletteList">
					<thead>
					  <tr>
						<th>#</th>
						<th>Game Name</th>
						<th>Open Time</th>
						<th>Close Time</th>
						<th>Status</th>
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
<div class="modal fade" id="addRouletteGameModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Game</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body batch_body">
		
	</div>
	</div>
  </div>
</div>

< 