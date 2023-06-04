  
		<form class="theme-form" id="editbidgalidissawarhistoryFrm" name="editbidgalidissawarhistoryFrm" method="post" >
			<div class="row">
				<input type="hidden" id="bid_id" name="bid_id" value="<?php if(isset($bid_id)){ echo $bid_id; } ?>">
				<input type="hidden" id="market_status" name="market_status" value="<?php if(isset($market_status)){ echo $market_status; } ?>">				<input type="hidden" id="pana" name="pana" value="<?php if(isset($pana)){ echo $pana; } ?>">

				<div class="form-group col-md-12">					<label class="col-form-label">Digit</label>							<select  id="digits" name="digits" class="form-control select2">					<?php for($i=0;$i<count($result);$i++){?>					<option <?php if($result[$i]==$digits){ echo  "selected" ;}?> value="<?php echo $result[$i];?>"><?php echo $result[$i];?></option>					<?php } ?>					</select>					</div>																
				 

				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="updategameBtn" name="updategameBtn">Update</button>
					
				</div>
			</div>
			<div class="form-group">
				<div id="error"></div>
			</div>
		</form>
	
 