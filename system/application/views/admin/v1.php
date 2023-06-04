<form class="theme-form" id="addroulettegameFrm" name="addroulettegameFrm" method="post" >
			<div class="row">
				<input type="hidden" name="game_id" value="<?php if(isset($game_id)) { echo $game_id; } ?>">
				<div class="form-group col-12">
					<label for="game_name">Game Name</label>
					<input type="text" name="game_name" id="game_name" class="form-control" placeholder="Enter Game Name" value="<?php if(isset($game_name)) { echo $game_name; } ?>"/>
				</div>
				
				<div class="row col-12">
				<div class="form-group col-6">
                            <label  for="open_time">Open Time</label>
                              <input name="open_time" id="open_time" class="form-control digits" type="time" value="<?php if(isset($open_time)) { echo $open_time; } ?>">
                            
                </div>
                <div class="form-group col-6">
                            <label for="close_time">Close Time</label>
                              <input name="close_time" id="close_time" class="form-control digits" type="time" value="<?php if(isset($close_time)) { echo $close_time; } ?>">
                            
                </div>
               </div>
				
				<div class="form-group col-12">
					<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn">Submit</button>
					<button type="reset" class="btn btn-danger waves-light m-t-10">Reset</button>
				
				</div>
			</div>
			<div class="form-group">
				<div id="msg"></div>
			</div>
		</form>