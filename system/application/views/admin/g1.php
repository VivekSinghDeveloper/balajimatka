 
<form class="theme-form" id="quesFrm" name="quesFrm" method="post" >
			 <input type="hidden" id="ques_id" name="ques_id" value="<?php if(isset($ques_id)){echo $ques_id;} ?>">
				
				<div class="row">
					 <div class="form-group col-md-4">
						<label for="">Question(Title)</label>
						<input class="form-control" name="ques_title" id="ques_title" type="text" placeholder="Enter Question" value="<?php if(isset($ques_title)){echo $ques_title;} ?>"/>
				</div>
				<div class="form-group col-12">
						<label>Answer</label>
						<textarea class="form-control" name="ques_ans" rows="10" id="ques_ans"  ><?php if(isset($ques_ans))echo $ques_ans; ?></textarea>
					</div>
					
			 
				
				 
				
				 
				
				 
					
				 </div>
				
					
				<div class="form-group col-12">
			<button type="submit" class="btn btn-primary waves-light m-t-10" id="submitBtn" name="submitBtn"> Submit</button>
			<button type="reset" class="btn btn-danger waves-light m-t-10" data-original-title="" title="">Reset</button>
			 
			<div class="form-group">
				<div id="errormsg"></div>
			</div>
		</form>
		
		
		
		 