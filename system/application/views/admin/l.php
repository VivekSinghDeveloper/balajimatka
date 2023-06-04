<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title d-flex align-items-center justify-content-between"><?php if(isset($banner_title2)) echo $banner_title2;?>
				 <a class="btn btn-primary btn-sm btn-float m-b-10" href="#addNoticeModal" role="button" data-toggle="modal">Add Notice</a></h4>
					<div class="">
					  <table id="noticeList" class="table table-striped">
						<thead>
						  <tr>
							<th>#</th>
							<th>Notice Title</th>
							<th>Content</th>
							<th>Notice Date</th>
							<th>Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						</table>
						</div>
						<div id="msg"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="addNoticeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Add Notice</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form class="theme-form" id="noticeFrm" name="noticeFrm" method="post" >
		<input type="hidden" name="notice_id" value="">	
			<div class="row">
					<div class="form-group col-6">
					<label for="exampleInputEmail1">Notice Title</label>
					<input type="text" name="notice_title" id="notice_title" class="form-control" placeholder="Enter Title"/>
				</div>	
				<div class="form-group col-6">
					<label>Notice Date</label>
					<?php $date = date('Y-m-d');?>
					<div class="date-picker">
						<div class="input-group">
						  <input class="form-control digits" type="date" value="<?php echo $date;?>" name="notice_date" id="notice_date" placeholder="Enter Notice Date">
						</div>
					</div>
				</div>
				<div class="form-group col-12">
					<label>Notice Content</label>
					<textarea class="form-control" name="description" rows="5" id="description"></textarea>
				</div>
				
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
					<button type="reset" class="btn btn-danger waves-light m-t-10">Reset</button>
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
<div class="modal fade" id="editNoticeModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Edit Notice</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body batch_body">	  
	  </div>
	</div>
  </div>
</div>
