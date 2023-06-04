<script type="text/javascript" src="<?php echo base_url();?>adminassets/tinymce/tinymce.min.js"></script>

<script type="text/javascript">var baseurl="<?php echo base_url();?>";	

tinymce.init({    mode : "specific_textareas",	

				  editor_selector : "textarea1",    

				  theme: "modern",	

				  branding: false,	

				  table_default_attributes: {		'class': 'table'	},

				  table_default_styles: {		'border-collapsed': 'collapse',		'width': '100%'	},	

				  table_responsive_width: true,    paste_data_images: true,    plugins: [      "advlist autolink lists link image charmap print preview hr anchor pagebreak",      "searchreplace wordcount visualblocks visualchars code fullscreen",      "insertdatetime media nonbreaking save table contextmenu directionality",      "emoticons template paste textcolor colorpicker textpattern"    ],    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",    toolbar2: "print preview media | forecolor backcolor emoticons",    /* image_advtab: true,     file_picker_callback: function(callback, value, meta) {      if (meta.filetype == 'image') {        $('#upload').trigger('click');        $('#upload').on('change', function() {          var file = this.files[0];          var reader = new FileReader();          reader.onload = function(e) {            callback(e.target.result, {              alt: ''            });          };          reader.readAsDataURL(file);        });      }    }, */	images_upload_url: baseurl+'tinymce-upload-image',        images_upload_handler: function (blobInfo, success, failure) {        var xhr, formData;              xhr = new XMLHttpRequest();        xhr.withCredentials = false;        xhr.open('POST', baseurl+'tinymce-upload-image');              xhr.onload = function() {            var json;                    if (xhr.status != 200) {                failure('HTTP Error: ' + xhr.status);                return;            }                    json = JSON.parse(xhr.responseText);                    if (!json || typeof json.location != 'string') {                failure('Invalid JSON: ' + xhr.responseText);                return;            }                    success(json.location);        };              formData = new FormData();        formData.append('file', blobInfo.blob(), blobInfo.filename());              xhr.send(formData);    },    templates: [{      title: 'Test template 1',      content: 'Test 1'    }, {      title: 'Test template 2',      content: 'Test 2'    }]  });</script>


<div class="page-content">
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
			  <div class="card-body">
			  <h4 class="card-titl d-flex align-items-center justify-content-betweene"><?php if(isset($banner_title2)) echo $banner_title2;?>
			 <a class="btn btn-primary btn-sm btn-float m-b-10" href="#addTipsModal" role="button" data-toggle="modal">Add Tips</a></h4>
				 
				  <table id="tipsList" class="table table-striped table-bordered" id="basic-1">
					<thead>
					  <tr>
						<th>#</th>
						<th>Title</th>
						<th>Banner Image</th>
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

<div class="modal fade" id="addTipsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Add Tips</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body">
		<form class="theme-form" id="tipsFrm" name="tipsFrm" method="post" >
		<input type="hidden" name="tips_id" value="">
		<input type="hidden" name="old_icon" value="">
			<div class="row">
				
				<div class="form-group col-12">
					<label for="exampleInputEmail1">Tipe Title</label>
					<input type="text" name="tips_title" id="tips_title" class="form-control" placeholder="Enter Tips Title"/>
				</div>
				
				<div class="form-group col-12">
					<label>Description</label>
					<textarea class="form-control textarea1" name="description" rows="10" id="description"></textarea>
				</div>
				
				<div class="form-group col-12">
					<label for="">Banner Image<span class="Img_ext">(Allow Only.jpeg,.jpg,.png)</span></label>
					<input class="form-control" name="file" id="file" type="file" onchange="return validateImageExtensionOther(this.value,1)"/>
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



<div class="modal fade" id="editTipsModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal_right_side" role="document">
	<div class="modal-content col-12 col-md-5">
	  <div class="modal-header">
		<h5 class="modal-title">Edit Tips</h5>
		<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  </div>
	  <div class="modal-body batch_body">
	  
	  </div>
	</div>
  </div>
</div>

