<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="content-type" content="text/html;charset=UTF-8">
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    
	<title><?php if(isset($title)){ echo $title; } ?></title>
	<?php if(isset($meta_description)) echo $meta_description; ?>
	
      <link rel="icon" href="fav.ico">
      <link href="<?php echo base_url();?>userassests/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url();?>userassests/css/font-awesome.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="<?php echo base_url();?>userassests/css/pe-icon-7-stroke.css" rel="stylesheet">
      <link href="<?php echo base_url();?>userassests/css/icofont.min.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/owl.carousel.min.css">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/immersive-video.css">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/owl.theme.default.min.css">
      <link href="<?php echo base_url();?>userassests/css/modal-video.min.css" rel="stylesheet">
      <link href="<?php echo base_url();?>userassests/css/magnific-popup.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/margins.css">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/paddings.css">
      <link href="<?php echo base_url();?>userassests/css/style.css" rel="stylesheet">
      <link href="<?php echo base_url();?>userassests/css/responsive.css" rel="stylesheet">
      <link rel="stylesheet" href="<?php echo base_url();?>userassests/css/colors/blue.css">
   </head>
   <body data-spy="scroll" data-target="#navbarCodeply" data-offset="70" style="overflow: visible;">
	<input type="hidden" id="base_url" value="<?php echo base_url();?>">
   <section id="home" class="text-left hero-section-1">
	  <div class="container">
		 <div class="align-items-center row">
			<div class="hero-content col-lg-12 p-100px-t p-50px-b md-p-10px-b">
				<div class="aboutIntroText minh500p">
				  <?php if(count($result)>0){ ?>
					<h3 class="m-20px-b mt40 text-align"> Matka <?php echo $game_name; ?> Result Chart</h3>
				  <?php } else { ?>
					<h2 class="m-20px-b mt40 text-align">This Game Result Chart Is not Updated Yet Please Check After Some Time<br/> Thank You!</h2>
				  <?php } ?>
				  <?php if(count($result)>0){ ?>
					<div class="row">
						<?php
							if(isset($result)) {
								foreach($result as $rs ){ 
									if($rs->open_number!=''){
										$open_num=$rs->open_number[0]+$rs->open_number[1]+$rs->open_number[2];
										if($open_num<10){
											$rs->open_result=$open_num;
										}else if($open_num>9){
											$rs->open_result=$open_num%10;
										}
									}else{
										$rs->open_result_1='***';
										$rs->open_result_2='*';
									}
									
									if($rs->close_number!=''){
										$close_num=$rs->close_number[0]+$rs->close_number[1]+$rs->close_number[2];
										
										if($close_num<10){
											$rs->close_result=$close_num;
										}else if($close_num>9){
											$close_res = $close_num%10;
											$rs->close_result=$close_res;
										}
									}else{
										$rs->close_result_1='***';
										$rs->close_result_2='*';
									}
									
									$winning_no ='';
									if($rs->open_number != '' && $rs->close_number != '')
									{
										$winning_no = $rs->open_result.$rs->close_result;
									}
									
					if(isset($winning_no) && $winning_no == 05 || $winning_no == 50 || $winning_no == 00 || $winning_no == 55 || $winning_no == 16 || $winning_no == 61 || $winning_no == 11 || $winning_no == 66 || $winning_no == 27 || $winning_no == 72 || $winning_no == 22 || $winning_no == 77 || $winning_no == 38 || $winning_no == 83 || $winning_no == 33 || $winning_no == 88 ||$winning_no == 49 || $winning_no == 94 || $winning_no == 44 || $winning_no == 99) { ?>
						<div class="col-md-2s col-2s">
							<div class="dtm_box">
								<p class="dtm_title"><?php $new_res_date=date("D",strtotime($rs->result_date)); 
								echo $new_res_date.'<br/>(';
								
								echo date("d M Y",strtotime($rs->result_date));
								echo ' )';?></p>
								<div class="row row_col">
									<div class="col-md-4 col-4 pr-0">
										<div class="dtm_box_inner d-table">
											<div class="d-table-cell">
												<font class="chart_result"><?php if(isset($rs->open_number) && $rs->open_number != ''){ echo $rs->open_number; }else { echo $rs->open_result_1; }?></font>
											</div>
										</div>
									</div>
									
									<div class="col-md-4 col-4 plr-0">
										<div class="dtm_box_inner dtm_box_mid d-table">
											<div class="d-table-cell">
												<h4 class="chart_result"><?php if(isset($rs->open_result)){ echo $rs->open_result; } else { echo $rs->open_result_2; } ?><?php if(isset($rs->close_result)){ echo $rs->close_result; } else { echo $rs->close_result_2; } ?></h4>
											</div>
										</div>
									</div>
									
									<div class="col-md-4 col-4 pl-0">
										<div class="dtm_box_inner d-table">
											<div class="d-table-cell">
												<font class="chart_result"><?php if(isset($rs->close_number) && $rs->close_number != ''){ echo $rs->close_number; }else { echo $rs->close_result_1; }?></font>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } else { ?>
						<div class="col-md-2s col-2s">
							<div class="dtm_box">
								<p class="dtm_title"><?php $new_res_date=date("D",strtotime($rs->result_date)); 
								echo $new_res_date.'<br/>(';
								
								echo date("d M Y",strtotime($rs->result_date));
								echo ' )';?></p>
								<div class="row row_col">
									<div class="col-md-4 col-4 pr-0">
										<div class="dtm_box_inner d-table">
											<div class="d-table-cell">
												<font><?php if(isset($rs->open_number) && $rs->open_number != ''){ echo $rs->open_number; }else { echo $rs->open_result_1; }?></font>
											</div>
										</div>
									</div>
									
									<div class="col-md-4 col-4 plr-0">
										<div class="dtm_box_inner dtm_box_mid d-table">
											<div class="d-table-cell">
												<h4><?php if(isset($rs->open_result)){ echo $rs->open_result; } else { echo $rs->open_result_2; } ?><?php if(isset($rs->close_result)){ echo $rs->close_result; } else { echo $rs->close_result_2; } ?></h4>
											</div>
										</div>
									</div>
									
									<div class="col-md-4 col-4 pl-0">
										<div class="dtm_box_inner d-table">
											<div class="d-table-cell">
												<font><?php if(isset($rs->close_number) && $rs->close_number != ''){ echo $rs->close_number; }else { echo $rs->close_result_1; }?></font>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					  <?php } }}}  ?>
					</div>			
				</div>
			</div>
		 </div>
	  </div>
   </section>
</div>


<footer id="footer-section" class="pt30 pb30 bg-black">
	   <div class="container">
		  <div class="row text-center">
			 <div class="col social-icons">
				<ul>
				<?php if(isset($facebook) && $facebook != '') { ?>
				   <li class="facebook wow zoomIn" data-wow-duration="1s"><a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a></li>
				<?php } ?>
				<?php if(isset($twitter) && $twitter != '') { ?>
				   <li class="twitter wow zoomIn" data-wow-duration="1s"><a href="#"><i class="fa fa-twitter"></i></a></li>
				<?php } ?>
				<?php if(isset($google_plus) && $google_plus != '') { ?>
				   <li class="google-plus wow zoomIn" data-wow-duration="1s"><a href=""><i class="fa fa-google-plus"></i></a></li>
				<?php } ?>
				<?php if(isset($youtube) && $youtube != '') { ?>
				   <li class="youtube wow zoomIn" data-wow-duration="1s"><a href="#"><i class="fa fa-youtube"></i></a></li>
				<?php } ?>
				<?php if(isset($instagram) && $instagram != '') { ?>
				   <li class="instagram wow zoomIn" data-wow-duration="1s"><a href="#"><i class="fa fa-instagram"></i></a></li>
				<?php } ?> 
				</ul>
			 </div>
			 <div class="col-sm-12 color-white">
				© Copyright 2020 By<a href="#">  Matka</a>. All Rights Reserved.
			 </div>
			 
		  </div>
	   </div>
	</footer>
 </div>
</div>

<script src="<?php echo base_url();?>userassests/js/jquery.min.js"></script>
	<script src="<?php echo base_url();?>userassests/js/customjs.js"></script>
	<script src="<?php echo base_url();?>userassests/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>userassests/js/jquery.scrollTo.min.js"></script>
	<script src="<?php echo base_url();?>userassests/js/jquery.nav.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>userassests/js/jquery.stellar.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>userassests/js/modal-video.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>userassests/js/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url();?>userassests/js/immersive-video.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>userassests/js/masonry.pkgd.min.js"></script>
	<script src="<?php echo base_url();?>userassests/js/app.js"></script>  
   </body>
</html>