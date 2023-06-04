<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/style.css" >
<title><?php if(isset($title)){echo $title;}?></title>
</head>

<body>
<header>
  <nav class="navbar fixed-top">
    <div class="container">
      <img src="<?php echo base_url();?>assets/images/logo1.png" class="navbar-brand">
    </div>
  </nav>
</header>

<section id="top">
    <div class="container">
        <h1><?php if(isset($title2)){echo $title2;}?></h1>
    </div>
</section>

<section id="buttons">
    <div class="container">
        <a href="app/<?php if(isset($app_name)){echo $app_name;}?>" download><button type="button"><i class="fa fa-download"></i> Download Now</button></a>
        <a href="app/<?php if(isset($app_name)){echo $app_name;}?>" download><button type="button"><i class="fa fa-play"></i> Google Play</button></a>
    </div>
</section>


<section id="contact">
    <div class="container">
        <h3>Contact us</h3>
			<a href="tel:<?php if(isset($mobile_1)){ echo $mobile_1;}?>"><h4><i class="fa fa-phone"></i> Call Us</h4>
            <p><?php if(isset($mobile_1)){ echo $mobile_1;}?></p></a>
			<a href="https://wa.me/<?php if(isset($whatsapp_no)){ echo $whatsapp_no;}?>" target="blank"><h4><i class="fa fa-whatsapp"></i> Whatsapp Us</h4>
            <p><?php if(isset($whatsapp_no)){ echo $whatsapp_no;}?></p></a>
            
    </div>
</section>

<footer>
    <div class="footer">
        <p>Copyright and all right reserved</p>
      </div>
</footer>


</body>
</html>