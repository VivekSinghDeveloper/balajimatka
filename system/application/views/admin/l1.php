<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Update Notice</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form class="theme-form" id="updatenoticeFrm" name="updatenoticeFrm" method="post" >
		<input type="hidden" name="notice_id" value="<?php if(isset($notice_id)){echo $notice_id;} ?>">	
			<div class="row">
					<div class="form-group col-6">
					<label for="exampleInputEmail1">Notice Title</label>
					<input type="text" name="notice_title" id="notice_title" value="<?php if(isset($notice_title)){echo $notice_title;}?>" class="form-control" placeholder="Enter Title"/>
				</div>	
				<div class="form-group col-6">
					<label>Notice Date</label>
					<?php $date = date('Y-m-d');?>
					<div class="date-picker">
						<div class="input-group">
						  <input class="form-control digits" type="date" value="<?php if(isset($notice_date)){echo $notice_date;}else{ echo $date;}?>" name="notice_date" id="notice_date" placeholder="Enter Notice Date">
						</div>
					</div>
				</div>
				<div class="form-group col-12">
					<label>Notice Content</label>
					<textarea class="form-control" name="description" rows="5" id="description"><?php if(isset($notice_msg)){echo $notice_msg;} ?></textarea>
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