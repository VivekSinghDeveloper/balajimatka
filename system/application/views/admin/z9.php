<div class="page-content">
	<div class="container-fluid">
		<div class="row"> 
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Full Sangam Numbers</h4>
						
						<h5>Open Ank</h5>	
					    <div class="" >	
						<?php foreach($result as $rs){if($rs->ank=="open"){?>
								
                             	<button class="digit_num_box"><?php  echo $rs->numbers; }?></button>
							
						<?php } ?>
                         </div>
						<h5>Close Ank</h5>	
						<div class="" >	
						<?php foreach($result as $rs){if($rs->ank=="close"){?>
								
                             	<button class="digit_num_box"><?php  echo $rs->numbers; }?></button>
							
						<?php } ?>
                         </div>
						
					</div>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>	


