<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@latest/dist/css/uikit.min.css">

</head>

<body>
    <div class="container">
        <div class="row head top_box">
            <div class="col-4">
                <img src="<?php echo base_url();?>assets/image/logo.png" alt="logo" class="logo">
            </div>
            <div class="col-8  appname d-flex">
                <div>
                    <h3 class="mt-3">Kalyan Super Matka</h3>
                    <h4 style="margin-top : -15px"class="sub_had">Play Matka App | Best App For Matka Play</h4>
                </div>

            </div>
            <div class="col-4 headstar">

                <img src="<?php echo base_url();?>assets/image/star.png" alt="star" class="star"><br>
            </div>
            <div class="col-8 headstar">
                <p style="margin-top:4px;"><b>100K+ Downloads</b></p>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
			<a href="app/<?php if(isset($app_name)){echo $app_name;}?>" download><button class="btn btn-success mt-3 w-100 button">install</button></a>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="uk-h3 uk-text-bold uk-text-center uk-text-uppercase"></div>
        <div class="uk-container" uk-slider>

            <div class="uk-position-relative uk-visible-toggle uk-light">

                <div class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m" uk-lightbox>
                    <div>
                        <a href="<?php echo base_url();?>assets/image/img1.jpeg" data-caption="1">
                            <img src="<?php echo base_url();?>assets/image/img1.jpeg" alt="" class="mb-img">
                            <div class="uk-position-center uk-panel">
                               
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url();?>assets/image/img2.jpeg" data-caption="2">
                            <img src="<?php echo base_url();?>assets/image/img2.jpeg" alt="" class="mb-img">
                            <div class="uk-position-center uk-panel">
                                
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url();?>assets/image/img3.jpeg" data-caption="3">
                            <img src="<?php echo base_url();?>assets/image/img3.jpeg" alt="" class="mb-img">
                            <div class="uk-position-center uk-panel">
                               
                            </div>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo base_url();?>assets/image/img4.jpeg" data-caption="4">
                            <img src="<?php echo base_url();?>assets/image/img4.jpeg" alt="" class="mb-img">
                            <div class="uk-position-center uk-panel">
                                
                            </div>
                        </a>
                    </div>
                </div>

                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
                    uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
                    uk-slider-item="next"></a>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="peragraph">
            <div class="sub_head">
                <h4>About this app <i class="fa fa-arrow-right sub_head_icon " aria-hidden="true"></i></h4>
            </div>
            <p style="text-align : justify">Kalyan Super Star Matka is the best preferred platforms to play online satta matka. We provide you the
                best interface to guess and win huge amounts through us. We Guarantee you the best online matka play
                with kalyan tricks and tips to play matka online. Have the best experience through our matka app and
                play satta with your skill to get huge rewards. Call us on the mentioned number to know more. We give
                you expert kalyan matka suggestions so that you can full fill your dreams with your own luck. Play Matka
                Online Today! Our aim to match your obsession and passion for the game by bringing the best in online
                matka, from kalyan and other major houses. We cover almost all the major matka play markets including
                rajdhani, kalyan, main ratan and other markets.</p>
        </div>
    </div>
    <div class="container">
        <div class="peragraph">
            <div class="sub_head">
                <h4>Disclaimer <i class="fa fa-arrow-right sub_head_icon" aria-hidden="true"></i></h4>
            </div>
            <p style="text-align : justify">Purchase Of Online Lottery Using This App Is Prohibited In The Territories Where Lotteries Are Banned.
                Playing Online Matka Below 18 Years Is Not Acceptable. Call Us On The Given Phone Number To Make A
                Complaint.</p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@latest/dist/js/uikit-icons.min.js"></script>
</body>

</html>

<style>
    .mb-img{padding-right:10px;}
</style> 