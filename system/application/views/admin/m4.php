		<form class="theme-form" id="offdayFrm" name="offdayFrm" method="post" >
			<div class="row">
				<input type="hidden" id="up_game_id" name="game_id" value="<?php if(isset($game_id)){ echo $game_id; } ?>">			<?php if(isset($result)) { foreach($result as $rs) { ?>
				<div class="form-group col-3">
					<input type="checkbox" name="day[]" <?php if($rs->weekday_status == 1) { ?> checked <?php } ?> value="<?php echo $rs->week_name; ?>">
					<label ><?php echo $rs->name; ?></label><br>				</div>				<div class="form-group col-4">					<label  for="open_time">Open Time</label>					<input name="open_time[]" id="open_time" class="form-control digits" type="time" value="<?php echo date('H:i', strtotime($rs->open_time)); ?>">                </div>                <div class="form-group col-4">                    <label for="close_time">Close Time</label>                    <input name="close_time[]" id="close_time" class="form-control digits" type="time" value="<?php echo date('H:i', strtotime($rs->close_time)); ?>">                </div>			<?php } } ?>	
			</div>
			<div class="form-group col-12">
				<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
			</div>
					</div>
				</div>
				<div class="form-group">
					<div id="u_msg"></div>
				</div>		</form>
	
 