  
		<form class="theme-form" id="editbidFrm" name="editbidFrm" method="post" >
			<div class="row">
				<input type="hidden" id="bid_id" name="bid_id" value="<?php if(isset($bid_id)){ echo $bid_id; } ?>">
				<input type="hidden" id="market_status" name="market_status" value="<?php if(isset($market_status)){ echo $market_status; } ?>">
				<div class="form-group col-md-4">	
				<label class="col-form-label">Digit</label>		
					<select  id="digit" name="digit" class="form-control">
					<?php foreach($result as $rs){?>
					<option <?php if($rs->numbers==$digits){ echo  "selected" ;}?> value="<?php echo $rs->numbers;?>"><?php echo $rs->numbers;?></option>
					<?php } ?>
					</select>	
				</div>
				
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="updategameBtn" name="updategameBtn">Update</button>
					
				</div>
			</div>
			<div class="form-group">
				<div id="error"></div>
			</div>
		</form>
	
 