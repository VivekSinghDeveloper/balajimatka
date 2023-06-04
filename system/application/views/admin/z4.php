<div class="page-content">
	<div class="container-fluid">
		<div class="row"> 
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Jodi Digit Numbers</h4>
						
						<div class=" digit_num_area">
						<?php foreach($result as $rs){?>
                              <button class="digit_num_box"><?php echo $rs->jodi_digit; ?></button>
							
						<?php } ?>
                        </div>
						
					</div>	
				</div>	
			</div>	
		</div>	
	</div>	
</div>	


