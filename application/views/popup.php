<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Home</title>
  
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/jquery/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/main-popup.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!--[endif]-->
  </head>
  <body>
      <div class="container">
        <div class="row">
          <?php echo $popup_content;?>
          <!--<div class="col-sm-8">
            <h1>Are You a Ruler ?</h1>
            <p>
              As a wise man once said, “Pop culture is for the masses - Indie culture is for the RULERS! <a href="#">The Indies Rule the World Network</a> is THE hub for the global indie culture. Subscribe now to become a RULER for only $4.99 /mo and get all the best content from the culture you love, curated by masters of culture.”
            </p>
          </div>-->
          <div class="col-sm-4 text-center">
            <img src="<?php echo base_url(); ?>assets/images/badge-img.png">
          </div>
        </div>
      </div>
    </section>
    <section class="ruler-boxs-section">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h2>Exclusive Content</h2>
            <h4>Never Be Out of the Loop</h4>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <h5>RULERS have 100% access to everything IRW Network has to offer:</h5>
          </div>
          <div class="col-sm-3">
            <div class="rule-box">
              <div class="rule-box-img">
                <img src="<?php echo base_url(); ?>assets/images/ruler-img-1.jpg">
              </div>
              <div class="rule-box-txt">
                <p>
                  Exclusive play Compete with other Rulers! Access to our Rulers Only Arcade/Casino, where you and Rulers from around the globe compete for perks & prizes. Fantasy Wrestling League with Legacy leaderboard.
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="rule-box">
              <div class="rule-box-img">
                <img src="<?php echo base_url(); ?>assets/images/ruler-img-2.jpg">
              </div>
              <div class="rule-box-txt">
                <p>
                  Weekly “Best Of” Podcast Compilations - Save yourself hundreds of hours and let our research staff bring you the most important moments from the top podcasts in the culture presented in neatly edited digests.
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="rule-box">
              <div class="rule-box-img">
                <img src="<?php echo base_url(); ?>assets/images/ruler-img-3.jpg">
              </div>
              <div class="rule-box-txt">
                <p>
                  Access to the World Infamous IRW Vault, where some of the most treasured wrestling archives on the planet exist from archive partners such as Kayfabe Commentary and various wrestling organizations.
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="rule-box">
              <div class="rule-box-img">
                <img src="<?php echo base_url(); ?>assets/images/ruler-img-4.jpg">
              </div>
              <div class="rule-box-txt">
                <p>
                  Weekly Indie Scene News Videos produced by our world famous production partner BHE
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="golden-ruler-section">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 golden-ruler-inner">
            <h2>Golden Ticket to RulerCon!</h2>
            <h4>The hottest Indie Culture Gathering there is!</h4>
          </div>
          <div class="col-sm-6 text-center">
            <img src="<?php echo base_url(); ?>assets/images/baner-img.png">
          </div>
        </div>
      </div>
    </section>
    <section class="disc-ruler-section">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 text-center disc-ruler-section-img">
            <img src="<?php echo base_url(); ?>assets/images/girl-img.png">
          </div>
          <div class="col-sm-6 disc-ruler-inner">
            <h2>DISCOUNTS!</h2>
            <h4>Look the Part!</h4>
            <p>
              Save 15% on Exclusive merchandise such as Apparel and memorabilia that can be found in the IRW store.
            </p>
            <a href="#" class="subcribe-btn">Subscribe Now! </a>
          </div>
        </div>
      </div>
  </body>
   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>assets/libs/jquery/jquery/dist/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
</html>