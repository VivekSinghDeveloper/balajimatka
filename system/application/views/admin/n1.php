<div class="page-content">
	<div class="container-fluid">

		<div class="row">

			<div class="col-sm-6 col-md-6 mr-auto ml-auto">

				<div class="card">

				  <div class="card-body">

				  <h4 class="card-title"><?php if(isset($banner_title2)) echo $banner_title2;?></h4>

				<form id="sendNotificationFrm" name="sendNotificationFrm" method="post" >


				<div class="">
			

						<div class="form-group">

						<label for="exampleInputEmail1">User List</label>

						<select name="user_id" id="user_id" class="form-control select2">
							<option value="">Select Users</option>
							<option value="all">All</option>
							<?php if(isset($user_result)){ foreach($user_result as $rs){?>
							
							<option value="<?php echo $rs->user_id;?>"><?php echo $rs->user_name.' ('.$rs->mobile.')';?></option>
							
							<?php } }?>
						</select>

					</div>	

					
					<div class="form-group">

						<label for="exampleInputEmail1">Notice Title</label>

						<input type="text" name="notice_title" id="notice_title" class="form-control" placeholder="Enter Title"/>

					</div>	
			

					<div class="form-group">

						<label>Notification Content</label>

						<textarea class="form-control" name="notification_content" rows="5" id="notification_content"></textarea>

					</div>
		

					<div class="form-group">

						<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>


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