  
		<form class="theme-form" id="editbidhistoryFrm" name="editbidhistoryFrm" method="post" >
			<div class="row">
				<input type="hidden" id="bid_id" name="bid_id" value="<?php if(isset($bid_id)){ echo $bid_id; } ?>">
				<input type="hidden" id="market_status" name="market_status" value="<?php if(isset($market_status)){ echo $market_status; } ?>">				<input type="hidden" id="pana" name="pana" value="<?php if(isset($pana)){ echo $pana; } ?>">
												<?php if($pana=='Full Sangam' or $pana=='Half Sangam'){ ?>								<div class="form-group col-md-12">					<label class="col-form-label">Digit</label>							<select  id="digit" name="digit" class="form-control select2">					<?php for($i=0;$i<count($result);$i++){?>					<option <?php if($result[$i]==$digits){ echo  "selected" ;}?> value="<?php echo $result[$i];?>"><?php echo $result[$i];?></option>					<?php } ?>					</select>					</div>								<div class="form-group col-md-12">					<label class="col-form-label">Close Digit</label>							<select  id="closedigits" name="closedigits" class="form-control select2">					<?php for($i=0;$i<count($result2);$i++){?>					<option <?php if($result2[$i]==$closedigits){ echo  "selected" ;}?> value="<?php echo $result2[$i];?>"><?php echo $result2[$i];?></option>					<?php } ?>					</select>					</div>								<?php } else { ?>										<div class="form-group col-md-12">					<label class="col-form-label">Digit</label>							<select  id="digit" name="digit" class="form-control select2">					<?php foreach($result as $rs){?>					<option <?php if($rs->numbers==$digits){ echo  "selected" ;}?> value="<?php echo $rs->numbers;?>"><?php echo $rs->numbers;?></option>					<?php } ?>					</select>					</div>									<?php } ?>
				 

				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="updategameBtn" name="updategameBtn">Update</button>
					
				</div>
			</div>
			<div class="form-group">
				<div id="error"></div>
			</div>
		</form>
	
 