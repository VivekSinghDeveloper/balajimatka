<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php if(isset($title)) echo $title;?></title>
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="<?php echo base_url();?>adminassets/images/favicon.ico">

	<!-- Bootstrap Css -->
	<link href="<?php echo base_url();?>adminassets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<!-- Icons Css -->
	<link href="<?php echo base_url();?>adminassets/css/icons.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url();?>adminassets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>adminassets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>adminassets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url();?>adminassets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<!-- App Css-->
	<link href="<?php echo base_url();?>adminassets/css/app.min.css?v=2" id="app-style" rel="stylesheet" type="text/css" />
	
	<link href="<?php echo base_url();?>adminassets/css/custom.css?v=11" rel="stylesheet" type="text/css" />
	
  </head>
  <body data-sidebar="dark">
    
	<div id="layout-wrapper">
	<?php if(isset($header)) echo $header ;?>
	<?php if(isset($middle)) echo $middle ;?>
	<?php if(isset($footer)) echo $footer ;?>
	</div>
		

	<input type="hidden" id="base_url" value="<?php echo base_url();?>">
	<input type="hidden" id="admin" value="<?php echo admin;?>">
	
	<div id="snackbar"></div>
	<div id="snackbar-info"></div>
	<div id="snackbar-error"></div>
	<div id="snackbar-success"></div>
	
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-lg">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-8 text-right">
						<p>Are you sure you want to logout? If you logout then your session is terminated.</p>
					</div>
					<div class="col-md-4 text-right">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">Cancel</button>
						<a href="<?php echo base_url().admin.'/logout'; ?>" class="btn btn-info waves-effect waves-light">Logout</a>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="deleteConfirmOpenResutlt" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this result?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<input type="hidden" name="delete_game_id" id="delete_game_id" value="">
						<button onclick="OpenDeleteResultData();" id="openDecBtn1" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<div class="modal fade" id="deleteConfirmOpenStarlineResutlt" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this result?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<input type="hidden" name="delete_starline_game_id" id="delete_starline_game_id">
						<button onclick="OpenDeleteStarlineResultData();" id="openDecBtn1" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<div class="modal fade" id="deleteConfirmOpenGalidisswarResutlt" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this result?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<input type="hidden" name="delete_gali_game_id" id="delete_gali_game_id">
						<button onclick="OpenDeleteGalidisswarResultData();" id="openDecBtn1" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<div class="modal fade" id="deleteConfirmCloseResutlt" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this result?</p>
					</div>
					<div class="col-md-12">
						<input type="hidden" name="delete_close_game_id" id="delete_close_game_id" value="">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="closeDeleteResultData();" id="closeDecBtn1" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	
	
	<div class="modal fade" id="fundRequestAcceptModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to accept this fund request?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="accept_request(this.value)" id="accept_request_id" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	<div class="modal fade" id="winnerListModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-lg">
		<div class="modal-content">
		<div class="modal-header">
        <h5 class="modal-title">Winner List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h5>Total Bid Amount : <b><span id="total_bid"></span></b></h5>
						<h5>Total Winning Amount : <b><span id="total_winneing_amt"></span></b></h5>
						
						<div class="dt-ext table-responsive" style="max-height: 400px;overflow-y: scroll;">

							<table class="table table-striped table-bordered">

								<thead> 

									<tr>

										<th>#</th>
										<th>User Name</th>
										<th>Bid Points</th>
										<th>Winning Amount</th>
										<th>Type</th>
										<th>Bid TX ID</th>

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
	</div>
	
	<div class="modal fade" id="fundRequestRejectModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to reject this fund request?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="reject_request(this.value)" id="reject_request_id" class="btn btn-danger waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="fundRequestAutoRejectModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to reject this fund request?</p>
					</div>
					<div class="form-group col-md-12">
						<label>Remark</label>
						<input type="text" name="reject_auto_remark" id="reject_auto_remark" class="form-control" placeholder="Enter Remark"/>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="reject_auto_request(this.value)" id="reject_auto_request_id" class="btn btn-danger waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
	
	<div class="modal fade" id="autoDeleteModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this fund request?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="delete_auto_request(this.value)" id="delete_auto_id" class="btn btn-danger waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="fundRequestAutoAcceptModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to accept this fund request?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="accept_auto_request(this.value)" id="accept_auto_request_id" class="btn btn-success waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	<div class="modal fade" id="autoDeleteModal" tabindex="-1" role="dialog" aria-hidden="true" >
	  <div class="modal-dialog modal-frame modal-top modal-md">
		<div class="modal-content">
		  <div class="modal-body">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<p>Are you sure you want to delete this fund request?</p>
					</div>
					<div class="col-md-12">
						<button class="btn btn-info waves-effect waves-light" data-dismiss="modal">No</button>
						<button onclick="delete_auto_request(this.value)" id="delete_auto_id" class="btn btn-danger waves-effect waves-light">Yes</button>
						
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
	
<div id="viewWithdrawRequest" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-0" id="myLargeModalLabel">Withdraw Request Detail</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body viewWithdrawRequestBody">

				

			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<div id="requestApproveModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Approve Withdraw Request</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="withdrawapproveFrm" method="post" enctype="multipart/formdata">
			<div class="form-group user_info">

			</div>
			<div class="form-group">
				<label for="">Payment Receipt Image<span class="Img_ext">(Allow Only.jpeg,.jpg,.png)</span></label>
				<input class="form-control" name="file" id="file" type="file" onchange="return validateImageExtensionOther(this.value,1)"/>
			</div>
			<div class="form-group">
				<label>Remark</label>
				<input type="text" name="remark" id="remark" class="form-control" placeholder="Enter Remark"/>
			</div>
		  <input type="hidden" name="withdraw_req_id" id="withdraw_req_id" value="<?php if(isset($withdraw_request_id)) echo $withdraw_request_id;?>">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-info btn-sm m-t-10" id="submitBtn" name="submitBtn">Submit</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="alert_msg_manager"></div>
		  </div>
	   </form>
      </div>
      <div class="modal-footer">

      </div>
    </div>
  </div>
</div>


<div id="requestRejectModel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Reject Withdraw Request</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
		<form class="theme-form"  id="withdrawRejectFrm" method="post" enctype="multipart/formdata">
			<div class="form-group">
				<label>Remark</label>
				<input type="text" name="remark" id="remark" class="form-control" placeholder="Enter Remark"/>
			</div>
		  <input type="hidden" name="withdraw_req_id" id="r_withdraw_req_id" value="<?php if(isset($withdraw_request_id)) echo $withdraw_request_id;?>">
		  <div class="form-group">							
		  <button type="submit" class="btn btn-info btn-sm m-t-10" id="submitBtnReject" name="submitBtnReject">Submit</button>
		  </div>
		  <div class="form-group m-b-0">
			 <div id="alert_msg"></div>
		  </div>
	   </form>
      </div>
    </div>
  </div>
</div>


	
<div class="modal fade " id="open-img-modal" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
        <button type="button" class="close" style="text-align:right" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <img class="my_image"/>
      </div>
	</div>
  </div>
</div>
				
	<script src="<?php echo base_url();?>adminassets/libs/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/libs/metismenu/metisMenu.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/libs/simplebar/simplebar.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/libs/node-waves/waves.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/libs/select2/js/select2.min.js"></script>
	<script src="<?php echo base_url();?>adminassets/js/pages/form-advanced.init.js"></script>
	<!-- Required datatable js -->
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/jszip/jszip.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/pdfmake/build/pdfmake.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/pdfmake/build/vfs_fonts.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
        
        <!-- Responsive examples -->
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>adminassets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

        <!-- Datatable init js -->
        <script src="<?php echo base_url();?>adminassets/js/pages/datatables.init.js"></script> 
	<!-- App js -->
	<script src="<?php echo base_url();?>adminassets/js/app.js"></script>
	<script src="<?php echo base_url();?>adminassets/js/customjs.js?v=<?php echo rand(1111,9999);?>"></script>
	
   
<script>
$(document).ready(function(){
	$(".open-img-modal"	).click(function(){
		var imgsrc = $(this).data('id');
		 	$('.my_image').attr('src',imgsrc);
			$("#open-img-modal").modal('show');
	});
	
	$(".categor_select_2").select2({
		placeholder: "Select Category",
		allowClear: true
	});
	
	$(".select_digit").select2({
		placeholder: "Select Digit",
		allowClear : true
	});
	
});

Date.prototype.toShortFormat = function() {

    var month_names =["Jan","Feb","Mar",
                      "Apr","May","Jun",
                      "Jul","Aug","Sep",
                      "Oct","Nov","Dec"];
    
    var day = this.getDate();
    var month_index = this.getMonth();
    var year = this.getFullYear();
	var hours = this.getHours();
    var minutes = this.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    
    return "" + day + "-" + month_names[month_index] + "-" + year + " " + strTime;
}
var today = new Date();
var exceldate = today.toShortFormat()
</script>
<script>
	 //$('.timepicker').val('')

	 var options = { 
					twentyFour: false,
					upArrow: 'wickedpicker__controls__control-up',
					downArrow: 'wickedpicker__controls__control-down', 
					close: 'wickedpicker__close',
					showSeconds: false,
					secondsInterval: 1,
					minutesInterval: 1,
					beforeShow: null,
					show: null,
					clearable: false,
					
		 }; 
		 	 var seridevi_open_time=$('#seridevi_open_time').val();;
		 	 var seridevi_close_time=$('#seridevi_close_time').val();;
		 	 var madhur_m_open_time=$('#madhur_m_open_time').val();;
		 	 var madhur_m_close_time=$('#madhur_m_close_time').val();;
		 	 var gold_d_open_time=$('#gold_d_open_time').val();;
		 	 var gold_d_close_time=$('#gold_d_close_time').val();;
		 	 var madhur_d_open_time=$('#madhur_d_open_time').val();;
		 	 var madhur_d_close_time=$('#madhur_d_close_time').val();;
		 	 var super_milan_open=$('#super_milan_open').val();;
		 	 var super_milan_close=$('#super_milan_close').val();;
		 	 var rajdhani_d_open=$('#rajdhani_d_open').val();;
		 	 var rajdhani_d_close=$('#rajdhani_d_close').val();;
		 	 var supreme_d_open=$('#supreme_d_open').val();;
		 	 var supreme_d_close=$('#supreme_d_close').val();;
		 	 var sridevi_night_open=$('#sridevi_night_open').val();;
		 	 var sridevi_night_close=$('#sridevi_night_close').val();;
		 	 var gold_night_open=$('#gold_night_open').val();;
		 	 var gold_night_close=$('#gold_night_close').val();;
		 	 var madhure_night_open=$('#madhure_night_open').val();;
		 	 var madhure_night_close=$('#madhure_night_close').val();;
		 	 var supreme_night_open=$('#supreme_night_open').val();;
		 	 var supreme_night_close=$('#supreme_night_close').val();;
		 	 var rajhdhani_night_open=$('#rajhdhani_night_open').val();;
		 	 var rajhdhani_night_close=$('#rajhdhani_night_close').val();;

	$('.timepicker').wickedpicker(options);
	 
	
	 
	 $('#seridevi_open_time').val(seridevi_open_time);;
	 $('#seridevi_close_time').val(seridevi_close_time);;
	 $('#madhur_m_open_time').val(madhur_m_open_time);;
	 $('#madhur_m_close_time').val(madhur_m_close_time);;
	 $('#gold_d_open_time').val(gold_d_open_time);;
	 $('#gold_d_close_time').val(gold_d_close_time);;
	 $('#madhur_d_open_time').val(madhur_d_open_time);;
	 $('#madhur_d_close_time').val(madhur_d_close_time);;
	 $('#super_milan_open').val(super_milan_open);;
	 $('#super_milan_close').val(super_milan_close);;
	 $('#rajdhani_d_open').val(rajdhani_d_open);;
	 $('#rajdhani_d_close').val(rajdhani_d_close);;
	 $('#supreme_d_open').val(supreme_d_open);;
	 $('#supreme_d_close').val(supreme_d_close);;
	 $('#sridevi_night_open').val(sridevi_night_open);;
	 $('#sridevi_night_close').val(sridevi_night_close);;
	 $('#gold_night_open').val(gold_night_open);;
	 $('#gold_night_close').val(gold_night_close);;
	 $('#madhure_night_open').val(madhure_night_open);;
	 $('#madhure_night_close').val(madhure_night_close);;
	 $('#supreme_night_open').val(supreme_night_open);;
	 $('#supreme_night_close').val(supreme_night_close);;
	 $('#rajhdhani_night_open').val(rajhdhani_night_open);;
	 $('#rajhdhani_night_close').val(rajhdhani_night_close);;

	 
</script>
				<script>
				var dataTable='';
						
						<?php if(isset($userListTableFlag) && $userListTableFlag == 1){ ?>
						dataTable = $('#userList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"user-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "mobile" },
										{ "data": "email" },
										{ "data": "insert_date" },
										{ "data": "wallet_balance" },
										{ "data": "betting_status" },
										{ "data": "transfer_status" },
										{ "data": "active_status" },
										{ "data": "view_details" },							
								],
								/* columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action ='<a title="View" href="'+base_url+admin+'/view-user/'+data.user_id+'"><button class="btn btn-outline-info btn-xs m-l-5" type="button" title="View">View</button></a>';
											
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.user_id+'-tb_user-user_id-status"><button class="btn btn-outline-success btn-xs m-l-5" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.user_id+'-tb_user-user_id-status"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" title="Activate">Activate</button></a>'; 
										} 
										return action;
									}
								}], */								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						<?php if(isset($unApprovedUserListTableFlag) && $unApprovedUserListTableFlag == 1){ ?>
						dataTable = $('#unApprovedUsersList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"un-approved-user-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "mobile" },
										{ "data": "email" },
										{ "data": "insert_date" },
										{ "data": "wallet_balance" },
										{ "data": "betting_status" },
										{ "data": "transfer_status" },
										{ "data": "active_status" },
										{ "data": "view_details" },						
								],
								/* columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action ='<a title="View" href="'+base_url+admin+'/view-user/'+data.user_id+'"><button class="btn btn-outline-info btn-xs m-l-5" type="button" title="View">View</button></a>';
										
										return action;
									}
								}], */								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
								
							<?php if(isset($fundRequestListTableFlag) && $fundRequestListTableFlag == 1){ ?>
						dataTable = $('#fundRequestList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"fund-request-list-grid-data","type": "POST","dataType": "json",complete: function (r){ $('#fundRequestList').lightGallery({
										selector: '.item'
									}); } },
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "request_amount" },
										{ "data": "request_number" },
										{ "data": "receipt_img" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										var action='';
										if (data.request_status == 1 || data.request_status == 2 ) {
											action+='<a href="javascript:void(0);" class="" data-id="'+data.fund_request_id+'"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" disabled >Accept</button></a>';

											action+='<a href="javascript:void(0);" class="" data-id="'+data.fund_request_id+'"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" disabled >Reject</button></a>';
										}else{
											action+='<a href="javascript:void(0);" class="openPopupAcceptRequest" data-id="'+data.fund_request_id+'"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" >Accept</button></a>';

											action+='<a href="javascript:void(0);" class="openPopupRejectRequest" data-id="'+data.fund_request_id+'"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" >Reject</button></a>'; 
										} 
										return action;
									}
								}],								
							});		
							
						dataTable.on('page.dt', function() {
						$('html, body').animate({
							scrollTop: $(".dataTables_wrapper").offset().top-50						   
							}, 'slow');						
							});	
							
						<?php }  ?>
						
						<?php if(isset($autoFundUserListTableFlag) && $autoFundUserListTableFlag == 1){ ?>
						dataTable = $('#autoFundRequestList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"auto-fund-request-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "amount" },
										{ "data": "tx_request_number" },
										{ "data": "txn_id" },
										{ "data": "reject_remark" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										var action='';
										if (data.fund_status == 1 || data.fund_status == 2 ) {
											action+='<a href="javascript:void(0);" class="" data-id="'+data.id+'"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" disabled >Accept</button></a>';

											action+='<a href="javascript:void(0);" class="" data-id="'+data.id+'"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" disabled >Reject</button></a>';
										}else{
											action+='<a href="javascript:void(0);" class="openPopupAcceptAutoRequest" data-id="'+data.id+'"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" >Accept</button></a>';

											action+='<a href="javascript:void(0);" class="openPopupRejectAutoRequest" data-id="'+data.id+'"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" >Reject</button></a>'; 
											
											action+='<a href="javascript:void(0);" class="openPopupDeleteAutoId"  data-id="'+data.id+'"><button class="btn btn-danger btn-xs mr-1" type="button">Delete</button></a>';
										} 
										return action;
									}
								}],								
							});		
							
						dataTable.on('page.dt', function() {
						$('html, body').animate({
							scrollTop: $(".dataTables_wrapper").offset().top-50						   
							}, 'slow');						
							});	
							
						<?php }  ?>
						
						
						
							<?php if(isset($withdrawRequestListTableFlag) && $withdrawRequestListTableFlag == 1){ ?>
						dataTable = $('#withdrawRequestList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"withdraw-request-list-grid-data","type": "POST","dataType": "json",complete: function (r){ /* $('#withdrawRequestList').lightGallery({
										selector: '.item'
									}); */ } },
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "mobile" },
										{ "data": "request_amount" },
										{ "data": "request_number" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": "view" },						
										{ "data": "action" },						
								],
								/* columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										var action='';
										action ='';
										return action;
									}
								}], */								
							});		
							
						dataTable.on('page.dt', function() {
						$('html, body').animate({
							scrollTop: $(".dataTables_wrapper").offset().top-50						   
							}, 'slow');						
							});	
							
						<?php }  ?>
						
							<?php if(isset($noticeListTableFlag) && $noticeListTableFlag == 1){ ?>
						dataTable = $('#noticeList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"notice-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "notice_title" },
										{ "data": "content" },
										{ "data": "notice_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action += '<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/edit-notice/'+data.notice_id+'" class="openPopupNotice"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" title="edit">Edit</button></a>';
											
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.notice_id+'-tb_notice-notice_id-status"><button class="btn btn-outline-success btn-xs m-l-5" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.notice_id+'-tb_notice-notice_id-status"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" title="Activate">Activate</button></a>'; 
										} 
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						<?php if(isset($gameNameListTableFlag) && $gameNameListTableFlag == 1){ ?>
						dataTable = $('#gameList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"game-name-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "game_name_hindi" },
										{ "data": "open_time" },
										{ "data": "close_time" },
										{ "data": "display_status" },
										{ "data": "display_market_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action+='<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/edit-game/'+data.game_id+'" class="openPopupEditGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="edit">Edit</button></a>';
											
										/*  if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.game_id+'-tb_games-game_id-status" ><button class="btn btn-success btn-sm mr-5" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.game_id+'-tb_games-game_id-status"><button class="btn btn-danger btn-sm mr-5" type="button" title="Activate">Activate</button></a>'; 
										} */ 
										/* if (data.market_status == 1) {
											action+='<a title="Market Close" class="success openCloseMarket" href="" id="success-'+data.game_id+'-tb_games-game_id-market_status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Market Close">Market Close</button></a>';
										}
										else{
											action+='<a class="danger openCloseMarket" href="" id="danger-'+data.game_id+'-tb_games-game_id-market_status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Market Open">Market Open</button></a>'; 
										} */
										action+='<a title="Off Day" href="javascript:void(0);" data-href="'+base_url+admin+'/off-day/'+data.game_id+'" class="openPopupoffDayGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="Off Day">market off day</button></a>';
										
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						
						<?php if(isset($starlineGameNameListTableFlag) && $starlineGameNameListTableFlag == 1){ ?>
						dataTable = $('#starlinegameList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"starline-game-name-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "game_name_hindi" },
										{ "data": "open_time" },
										{ "data": "display_status" },
										{ "data": "display_market_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action+='<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/edit-starline-game/'+data.game_id+'" class="openPopupEditStarlineGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="edit">Edit</button></a>';
											
										/* if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.game_id+'-tb_starline_games-game_id-status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.game_id+'-tb_starline_games-game_id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										} */
										 	 if (data.market_status == 1) {
											action+='<a title="Market Close" class="success openCloseMarket" href="" id="success-'+data.game_id+'-tb_starline_games-game_id-market_status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Market Close">Market Close</button></a>';
										}
										else{
											action+='<a class="danger openCloseMarket" href="" id="danger-'+data.game_id+'-tb_starline_games-game_id-market_status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Market Open">Market Open</button></a>'; 
										} 
										/*action+='<a title="Off Day" href="javascript:void(0);" data-href="'+base_url+admin+'/starline-off-day/'+data.game_id+'" class="openPopupStarlineoffDayGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="Off Day">market off day</button></a>';*/
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						
						
						<?php if(isset($galidisswarGameNameListTableFlag) && $galidisswarGameNameListTableFlag == 1){ ?>
						dataTable = $('#galidisswargameList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"galidisswar-game-name-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "game_name_hindi" },
										{ "data": "open_time" },
										{ "data": "display_status" },
										{ "data": "display_market_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action+='<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/edit-galidisswar-game/'+data.game_id+'" class="openPopupEditgalidisswarGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="edit">Edit</button></a>';
											
										/* if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.game_id+'-tb_gali_disswar_games-game_id-status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.game_id+'-tb_gali_disswar_games-game_id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										} */
										if (data.market_status == 1) {
											action+='<a title="Market Close" class="success openCloseMarket" href="" id="success-'+data.game_id+'-tb_gali_disswar_games-game_id-market_status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Market Close">Market Close</button></a>';
										}
										else{
											action+='<a class="danger openCloseMarket" href="" id="danger-'+data.game_id+'-tb_gali_disswar_games-game_id-market_status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Market Open">Market Open</button></a>'; 
										} 
										/*action+='<a title="Off Day" href="javascript:void(0);" data-href="'+base_url+admin+'/galidisawar-off-day/'+data.game_id+'" class="openPopupGalidisawaroffDayGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="Off Day">market off day</button></a>';*/
										 
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						<?php if(isset($user_wallet_transaction_data_flag_data) && $user_wallet_transaction_data_flag_data==1){ ?>
								var user_id = $("#user_id").val();
							dataTable2 = $('#allTransactionTable').DataTable( {
								"processing": true,
								"serverSide": true,
								"order": [0,"desc"],
								"ajax":{"url":base_url+"all-transaction-table-grid-data","type": "POST","data":{user_id:user_id},"dataType": "json"},
								"columns": [
									{ "data": "#" },
									{ "data": "amount" },
									{ "data": "tx_note" },
									{ "data": "transfer_note" }, 
									{ "data": "insert_date" },
									{ "data": "tx_req_no" },
								],
																					
								});												
								dataTable2.on('page.dt', function() {						  
								$('html, body').animate({							
								scrollTop: $(".dataTables_wrapper").offset().top-50						  
								}, 'slow');						
								});											
					<?php } ?>
					
					<?php if(isset($user_credit_transaction_data_flag_data) && $user_credit_transaction_data_flag_data==1){ ?>
								var user_id = $("#user_id").val();
							dataTable2 = $('#inTransactionTable').DataTable( {
								"processing": true,
								"serverSide": true,
								"order": [0,"desc"],
								"ajax":{"url":base_url+"credit-transaction-table-grid-data","type": "POST","data":{user_id:user_id},"dataType": "json"},
								"columns": [
									{ "data": "#" },
									{ "data": "amount" },
									{ "data": "tx_note" },
									{ "data": "transfer_note" },
									{ "data": "insert_date" },
									{ "data": "tx_req_no" },
								],
																					
								});												
								dataTable2.on('page.dt', function() {						  
								$('html, body').animate({							
								scrollTop: $(".dataTables_wrapper").offset().top-50						  
								}, 'slow');						
								});											
					<?php } ?>
					<?php if(isset($user_debit_transaction_data_flag_data) && $user_debit_transaction_data_flag_data==1){ ?>
								var user_id = $("#user_id").val();
							dataTable2 = $('#outTransactionTable').DataTable( {
								"processing": true,
								"serverSide": true,
								"order": [0,"desc"],
								"ajax":{"url":base_url+"debit-transaction-table-grid-data","type": "POST","data":{user_id:user_id},"dataType": "json"},
								"columns": [
									{ "data": "#" },
									{ "data": "amount" },
									{ "data": "tx_note" },
									{ "data": "transfer_note" },
									{ "data": "insert_date" },
									{ "data": "tx_req_no" },
								],
																					
								});												
								dataTable2.on('page.dt', function() {						  
								$('html, body').animate({							
								scrollTop: $(".dataTables_wrapper").offset().top-50						  
								}, 'slow');						
								});											
					<?php } ?>
					
							<?php if(isset($imageSliderListTableFlag) && $imageSliderListTableFlag == 1){ ?>
						dataTable = $('#imagesList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"slider-images-list-grid-data","type": "POST","dataType": "json",complete: function (r){ $('#imagesList').lightGallery({
										selector: '.item'
									}); } },
							"columns": [
										{ "data": "#" },
										{ "data": "slider_image" },
										{ "data": "display_order" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										var action='';
										action+='<a href="javascript:void(0);" class="openPopupDeleteImage"  data-id="'+data.image_id+'"><button class="btn btn-danger btn-xs mr-1" type="button">Delete</button></a>';
										
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.image_id+'-tb_slider_images-image_id-status"><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.image_id+'-tb_slider_images-image_id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										}
										return action;										
									}
								}],								
							});		
							
						dataTable.on('page.dt', function() {
						$('html, body').animate({
							scrollTop: $(".dataTables_wrapper").offset().top-50						   
							}, 'slow');						
							});	
							
						<?php }  ?>
						
						<?php if(isset($user_bid_history_data_flag_data) && $user_bid_history_data_flag_data==1){ ?>
								var user_id = $("#user_id").val();
							dataTable2 = $('#bidHistoryTable').DataTable( {
								"processing": true,
								"serverSide": true,
								"order": [0,"desc"],
								"ajax":{"url":base_url+"user-bid-history-table-grid-data","type": "POST","data":{user_id:user_id},"dataType": "json"},
								"columns": [
									{ "data": "#" },
									{ "data": "game_name" },
									{ "data": "game_type" },
									{ "data": "session" },
									{ "data": "digits" },
									{ "data": "close_digits" },
									{ "data": "points" },
									{ "data": "insert_date" },
								],
																					
							});												
							dataTable2.on('page.dt', function() {						  
							$('html, body').animate({							
							scrollTop: $(".dataTables_wrapper").offset().top-50						  
							}, 'slow');						
							});											
						<?php } ?>
						
						<?php if(isset($userQueryListTableFlag) && $userQueryListTableFlag == 1){ ?>
						dataTable = $('#userQueryList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"users-querys-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "user_name" },
										{ "data": "mobile" },
										{ "data": "email" },
										{ "data": "query" },
										{ "data": "insert_date" },			
								],
									});												
									dataTable2.on('page.dt', function() {						  
									$('html, body').animate({							
									scrollTop: $(".dataTables_wrapper").offset().top-50						  
									}, 'slow');						
									});	
						<?php } ?>
						
						<?php if(isset($resultHistoryListTableFlag) && $resultHistoryListTableFlag == 1){ ?>
						dataTable = $('#gameResultHistory').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"result-history-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "result_date" },
										{ "data": "open_date" },
										{ "data": "close_date" },
										{ "data": "open_result" },			
										{ "data": "close_result" },			
								],
									});												
									dataTable2.on('page.dt', function() {						  
									$('html, body').animate({							
									scrollTop: $(".dataTables_wrapper").offset().top-50						  
									}, 'slow');						
									});	
						<?php } ?>
						
						
						<?php if(isset($starlineResultHistoryListTableFlag) && $starlineResultHistoryListTableFlag == 1){ ?>
						dataTable = $('#starlineGameResultHistory').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"starline-result-history-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "result_date" },
										{ "data": "open_date" },
										{ "data": "open_result" },					
								],
									});												
									dataTable2.on('page.dt', function() {						  
									$('html, body').animate({							
									scrollTop: $(".dataTables_wrapper").offset().top-50						  
									}, 'slow');						
									});	
						<?php } ?>
						
						<?php if(isset($resultHistoryListTableLoadFlag) && $resultHistoryListTableLoadFlag==1){ ?>
							var ob2='';
							$.ajax({
								type: "POST",
								url: base_url + "result-history-list-load-data",
								data: {date:'<?php echo date('Y-m-d');?>'},
								dataType: "json",
								success: function (data) {
									$.each(data, function(key, val) {
										ob2+='<tr><td>'+val.sn+'</td><td>'+val.game_name+'</td><td>'+val.result_date+'</td><td>'+val.open_date+'</td><td>'+val.close_date+'</td><td>'+val.open_result+'</td><td>'+val.close_result+'</td></tr>'
									});
									$('#getGameResultHistory').html(ob2);
									
								}
							});
						<?php } ?>
							<?php if(isset($starlineResultHistoryListTableLoadFlag) && $starlineResultHistoryListTableLoadFlag==1){ ?>
							var ob2='';
							$.ajax({
								type: "POST",
								url: base_url + "starline-result-history-list-load-data",
								data: {date:'<?php echo date('Y-m-d');?>'},
								dataType: "json",
								success: function (data) {
									$.each(data, function(key, val) {
										ob2+='<tr><td>'+val.sn+'</td><td>'+val.game_name+'</td><td>'+val.result_date+'</td><td>'+val.open_date+'</td><td>'+val.open_result+'</td></tr>'
									});
									$('#getStarlineResultHistory').html(ob2);
									
								}
							});
						<?php } ?>
						
						
						<?php if(isset($galidisswarResultHistoryListTableFlag) && $galidisswarResultHistoryListTableFlag == 1){ ?>
						dataTable = $('#galidisswarGameResultHistory').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"galidisswar-result-history-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "result_date" },
										{ "data": "open_date" },
										{ "data": "open_result" },					
								],
									});												
									dataTable2.on('page.dt', function() {						  
									$('html, body').animate({							
									scrollTop: $(".dataTables_wrapper").offset().top-50						  
									}, 'slow');						
									});	
						<?php } ?>
						
						
						<?php if(isset($subAdminListTableFlag) && $subAdminListTableFlag == 1){ ?>
						dataTable = $('#subAdminList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"sub-admin-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "full_name" },
										{ "data": "user_name" },
										{ "data": "email" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.user_id+'-tb_admin-id-status"><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.user_id+'-tb_admin-id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										} 
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						<?php if(isset($tipsListTableFlag) && $tipsListTableFlag == 1){ ?>
						dataTable = $('#tipsList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"tips-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "title" },
										{ "data": "banner_image" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
										
										action += '<a title="view" href="'+base_url+admin+'/view-tips/'+data.tips_id+'"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" title="view">View</button></a>';
										
										action += '<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/edit-tips/'+data.tips_id+'" class="openPopupEditTips"><button class="btn btn-primary btn-xs mr-1" type="button" title="edit">Edit</button></a>';
										
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.tips_id+'-tb_tips-tips_id-status"><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.tips_id+'-tb_tips-tips_id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										} 
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						
						
							<?php if(isset($chatQuesListTableFlag) && $chatQuesListTableFlag == 1){ ?>
						dataTable = $('#quesTable').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"ques-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "ques_title" },
										{ "data": "insert_date" },
										{ "data": "display_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										var action='';
										action += '<a title="view" href="javascript:void(0);" data-href="'+base_url+admin+'/view-ques/'+data.ques_id+'" class="openPopupViewques"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" title="view">View</button></a>';
										
										action += '<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/add-ques/'+data.ques_id+'" class="openPopupAddques"><button class="btn btn-outline-primary btn-xs m-l-5" type="button" title="edit">Edit</button></a>';
									
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.ques_id+'-tb_chat_ques-ques_id-status"><button class="btn btn-outline-success btn-xs m-l-5" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.ques_id+'-tb_chat_ques-ques_id-status"><button class="btn btn-outline-danger btn-xs m-l-5" type="button" title="Activate">Activate</button></a>'; 
										} 
										return action;									
									}
								}],								
							});		
							
						dataTable.on('page.dt', function() {
						$('html, body').animate({
							scrollTop: $(".dataTables_wrapper").offset().top-50						   
							}, 'slow');						
							});	
							
						<?php }  ?>
						
						
						
						<?php if(isset($rouletteGameNameListTableFlag) && $rouletteGameNameListTableFlag == 1){ ?>
						dataTable = $('#gameRouletteList').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"roulette-game-name-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name" },
										{ "data": "open_time" },
										{ "data": "close_time" },
										{ "data": "display_status" },
										{ "data": "display_market_status" },
										{ "data": null },						
								],
								columnDefs: [{
									targets: [-1], render: function (a, b, data, d) {
										 var action='';
											action+='<a title="Edit" href="javascript:void(0);" data-href="'+base_url+admin+'/add-roulette-game/'+data.game_id+'" class="openPopupAddRouletteGame"><button  class="btn btn-primary btn-xs mr-1" type="button"  title="edit">Edit</button></a>';
											
										 if (data.status == 1) {
											action+='<a title="Inactivate" class="success blockUnblock" href="" id="success-'+data.game_id+'-tb_roulette_game-game_id-status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Inactivate">Inactivate</button></a>';
										}
										else{
											action+='<a class="danger blockUnblock" href="" id="danger-'+data.game_id+'-tb_roulette_game-game_id-status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Activate">Activate</button></a>'; 
										} 
										 if (data.market_status == 1) {
											action+='<a title="Market Close" class="success openCloseMarket" href="" id="success-'+data.game_id+'-tb_roulette_game-game_id-market_status" ><button class="btn btn-success btn-xs mr-1" type="button" title="Market Close">Market Close</button></a>';
										}
										else{
											action+='<a class="danger openCloseMarket" href="" id="danger-'+data.game_id+'-tb_roulette_game-game_id-market_status"><button class="btn btn-danger btn-xs mr-1" type="button" title="Market Open">Market Open</button></a>'; 
										} 
										return action;
									}
								}],								
							});												
								dataTable.on('page.dt', function() {
								$('html, body').animate({
									scrollTop: $(".dataTables_wrapper").offset().top-50						   
									}, 'slow');						
									});	
							
						<?php }  ?>
						
						
							<?php if(isset($rouletteResultHistoryListTableFlag) && $rouletteResultHistoryListTableFlag == 1){ ?>
						dataTable = $('#roulettegameResultHistory').DataTable( {
							"processing": true,
							"serverSide": true,
							"order": [0,"desc"],
							"ajax":{"url":base_url+"roulette-result-history-list-grid-data","type": "POST","dataType": "json"},
							"columns": [
										{ "data": "#" },
										{ "data": "game_name"},
										{ "data": "result_date" },
										{ "data": "open_date" },
										{ "data": "number" },					
								],
									});												
									dataTable2.on('page.dt', function() {						  
									$('html, body').animate({							
									scrollTop: $(".dataTables_wrapper").offset().top-50						  
									}, 'slow');						
									});	
						<?php } ?>
						
						
						
						
					
					
						
						
		</script>
		
	
  </body>

</html>