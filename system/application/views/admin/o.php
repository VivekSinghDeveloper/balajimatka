<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			  <h4 class="card-title d-flex align-items-center justify-content-between"><?php if(isset($banner_title2)) echo $banner_title2;?>
			 <a class="btn btn-primary btn-sm btn-float m-b-10" href="#addSliderImageModal" role="button" data-toggle="modal">Add Slider Image</a></h4>
				  <table id="imagesList" class="table table-striped table-bordered">
					<thead>
					  <tr>
						<th>#</th>
						<th>Slider Image</th>
						<th>Display Order</th>
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
</div>
<div class="modal fade" id="addSliderImageModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Add Slider Image</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form class="theme-form" id="sliderImageFrm" name="sliderImageFrm" method="post" >
			<div class="row">
				
				<div class="form-group col-12">
					<label for="">Slider Image<span class="Img_ext">(Allow Only.jpeg,.jpg,.png)</span></label>
					<input class="form-control" name="file" id="file" type="file" onchange="return validateImageExtensionOther(this.value,1)"/>
				</div>
				
				<div class="form-group col-12">
					<label for="exampleInputEmail1">Display Order</label>
					<input type="number" name="display_order" id="display_order" class="form-control" placeholder="Enter Image Display Order"/>
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

<div class="modal fade" id="imageDeleteModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="delete_this(this.value)" id="delete_id" class="btn btn-danger waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
