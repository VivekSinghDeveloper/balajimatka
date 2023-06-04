<script type="text/javascript" src="<?php echo base_url();?>adminassets/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url();?>adminassets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">var baseurl="<?php echo base_url();?>";	
tinymce.init({    mode : "specific_textareas",	
				  editor_selector : "textarea1",    
				  theme: "modern",	
				  branding: false,	
				  table_default_attributes: {		'class': 'table'	},
				  table_default_styles: {		'border-collapsed': 'collapse',		'width': '100%'	},	
				  table_responsive_width: true,    paste_data_images: true,    plugins: [      "advlist autolink lists link image charmap print preview hr anchor pagebreak",      "searchreplace wordcount visualblocks visualchars code fullscreen",      "insertdatetime media nonbreaking save table contextmenu directionality",      "emoticons template paste textcolor colorpicker textpattern"    ],    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",    toolbar2: "print preview media | forecolor backcolor emoticons",    /* image_advtab: true,     file_picker_callback: function(callback, value, meta) {      if (meta.filetype == 'image') {        $('#upload').trigger('click');        $('#upload').on('change', function() {          var file = this.files[0];          var reader = new FileReader();          reader.onload = function(e) {            callback(e.target.result, {              alt: ''            });          };          reader.readAsDataURL(file);        });      }    }, */	images_upload_url: baseurl+'tinymce-upload-image',        images_upload_handler: function (blobInfo, success, failure) {        var xhr, formData;              xhr = new XMLHttpRequest();        xhr.withCredentials = false;        xhr.open('POST', baseurl+'tinymce-upload-image');              xhr.onload = function() {            var json;                    if (xhr.status != 200) {                failure('HTTP Error: ' + xhr.status);                return;            }                    json = JSON.parse(xhr.responseText);                    if (!json || typeof json.location != 'string') {                failure('Invalid JSON: ' + xhr.responseText);                return;            }                    success(json.location);        };              formData = new FormData();        formData.append('file', blobInfo.blob(), blobInfo.filename());              xhr.send(formData);    },    templates: [{      title: 'Test template 1',      content: 'Test 1'    }, {      title: 'Test template 2',      content: 'Test 2'    }]  });</script>

<div class="page-content"
<form class="theme-form" id="updateTipsFrm" name="updateTipsFrm" method="post" >
<input type="hidden" name="tips_id" value="<?php if(isset($tips_id)) { echo $tips_id; } ?>">
	<div class="row">
		<div class="form-group col-12">
			<label for="exampleInputEmail1">Tipe Title</label>
			<input type="text" name="tips_title" id="u_tips_title" class="form-control" placeholder="Enter Tips Title" value="<?php if(isset($title)){ echo $title; }?>"/>
		</div>
		<div class="form-group col-12">
			<label>Description</label>
			<textarea class="form-control textarea1" name="description" rows="10" id="u_description"><?php if(isset($description)){ echo $description; }?></textarea>
		</div>
		
		<div class="form-group col-12">
			<label for="">Banner Image<span class="Img_ext">(Allow Only.jpeg,.jpg,.png)</span></label>
			<input class="form-control" name="file" id="file" type="file" onchange="return validateImageExtensionOther(this.value,1)" />
		</div>
		<?php if(isset($banner_image) && $banner_image != ''){?>
			<div class="form-group col-md-3">
				<input type="hidden" name="old_icon" value="<?php if(isset($banner_image)){echo $banner_image;} ?>" />
				<img src="<?php echo base_url().'/uploads/file/'.$banner_image;?>" width="100">
			</div>
		 <?php } ?>
		
		<div class="form-group col-12">
			<button type="submit" class="btn btn-primary waves-light m-t-10" id="updateBtn" name="updateBtn">Update</button>
			<button type="reset" class="btn btn-danger waves-light m-t-10" data-original-title="" title="">Reset</button>
		</div>
	</div>
	<div class="form-group m-b-0">
		<div id="alertmsg"></div>
	</div>
</form>
</div>