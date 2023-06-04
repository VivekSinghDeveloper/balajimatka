  
		<form class="theme-form" id="updateeditgameFrm" name="updateeditgameFrm" method="post" >
			<div class="row">
				<input type="hidden" id="up_game_id" name="game_id" value="<?php if(isset($game_id)){ echo $game_id; } ?>">
				<div class="form-group col-12">
					<label>Game Name</label>
					<input type="text" name="game_name" id="up_game_name" class="form-control" placeholder="Enter Game Name" value="<?php if(isset($game_name)){ echo $game_name; } ?>" />
				</div>
				
				<div class="form-group col-12">
					<label for="game_name_hindi">Game Name Hindi</label>
					<input type="text" name="game_name_hindi" id="up_game_name_hindi" class="form-control" value="<?php if(isset($game_name_hindi)){ echo $game_name_hindi; } ?>" placeholder="Enter Game Name In Hindi"/>
				</div>
				
				
			<?php /*?>	<div class="form-group col-6">
                            <label  for="open_time">Open Time</label>

                              <input name="open_time" id="up_open_time" class="form-control digits" value="<?php  echo $open_time; ?>" type="time" readonly>
                            
                </div>
                <div class="form-group col-6">
                            <label for="close_time">Close Time</label>
                              <input name="close_time" id="up_close_time" class="form-control digits" type="time" value="<?php if(isset($close_time)){ echo $close_time; } ?>" readonly>
                            
                </div>
               <?php  */?>
               
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="updategameBtn" name="updategameBtn">Update</button>
					
				</div>
			</div>
			<div class="form-group">
				<div id="u_msg"></div>
			</div>
		</form>
	
 