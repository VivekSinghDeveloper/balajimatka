<div class="page-content">
 <div class="container-fluid">
	<div class="row">
	<!-- Zero Configuration  Starts-->	
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			  <h4 class="card-title d-flex align-items-center justify-content-between"><?php if(isset($banner_title2)) echo $banner_title2;?>
			   <a class="btn btn-primary btn-sm btn-float openPopupAddques" href="javascript:void(0);" data-href="<?php echo base_url().admin.'/add-ques/0' ; ?>" role="button" data-toggle="modal">Add Question</a>
			  </h4>
			 
				  <table class="table table-striped table-bordered" id="quesTable">
					<thead>
					  <tr>
						<th>#</th>
						<th>Question(Title)</th>
						<th>Creation Date</th>
						<th>Status</th>
						<th>Action</th>
					  </tr>
					</thead>
					</table>
				 
					<div id="msg"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="addQuesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-6">
	  <div class="modal-header">
		<h5 class="modal-title">Question</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body batch_body">
		
	</div>
	</div>
  </div>
</div>

 <div class="modal fade" id="addQuesViewModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-6">
	  <div class="modal-header">
		<h5 class="modal-title">View Question Detail</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body batch_body">
	  
	  </div>
	</div>
  </div>
</div>