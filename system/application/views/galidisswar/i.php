  
		<form class="theme-form" id="galidisawaroffdayFrm" name="galidisawaroffdayFrm" method="post" >
			<div class="row">
				<input type="hidden" id="up_game_id" name="game_id" value="<?php if(isset($game_id)){ echo $game_id; } ?>">
				<div class="form-group col-12">
					<input type="checkbox" id="monday" name="day[]" <?php if(in_array("monday",$market_off_day)){ echo 'checked';}?> value="monday">
					<label for="monday"> Monday</label><br>
					<input type="checkbox" id="tuesday" name="day[]"  <?php if(in_array("tuesday",$market_off_day)){ echo 'checked';}?> value="tuesday">
					<label for="tuesday"> Tuesday</label><br>
					<input type="checkbox" id="wednesday" name="day[]"  <?php if(in_array("wednesday",$market_off_day)){ echo 'checked';}?> value="wednesday">
					<label for="wednesday"> Wednesday</label><br>
					<input type="checkbox" id="thrusday" name="day[]" <?php if(in_array("thrusday",$market_off_day)){ echo 'checked';}?> value="thrusday">
					<label for="thrusday"> Thrusday</label><br>
					<input type="checkbox" id="friday" name="day[]" <?php if(in_array("friday",$market_off_day)){ echo 'checked';}?> value="friday">
					<label for="friday"> Friday</label><br>
					<input type="checkbox" id="saturday" name="day[]" <?php if(in_array("saturday",$market_off_day)){ echo 'checked';}?> value="saturday">
					<label for="saturday"> Saturday</label><br>
					<input type="checkbox" id="sunday" name="day[]" <?php if(in_array("sunday",$market_off_day)){ echo 'checked';}?> value="sunday">
					<label for="sunday"> Sunday</label><br>
					
				</div>
				
				
               
				
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
					
				</div>
				
				</div>
			</div>
			<div class="form-group">
				<div id="u_msg"></div>
			</div>
		</form>
	
 