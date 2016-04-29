<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RaspBerry & Arduino in your life - DIY</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('res/home'); ?>/css/bootstrap.min.css" rel="stylesheet">
        <!-- for fontawesome icon css file -->
        <link href="<?php echo base_url('res/home'); ?>/css/font-awesome.min.css" rel="stylesheet">
        <!-- for content animate css file -->
        <link rel="stylesheet" href="<?php echo base_url('res/home'); ?>/css/animate.css">
        <!-- google fonts  -->
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Varela' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>   
        <!-- for news ticker css file -->
        <link href="<?php echo base_url('res/home'); ?>/css/li-scroller.css" rel="stylesheet">
        <!-- slick slider css file -->
        <link href="<?php echo base_url('res/home'); ?>/css/slick.css" rel="stylesheet">
        <!-- for fancybox slider -->
        <link href="<?php echo base_url('res/home'); ?>/css/jquery.fancybox.css" rel="stylesheet">    
        <!-- website theme file -->
        <!-- <link href="css/theme-red.css" rel="stylesheet"> -->

        <link href="<?php echo base_url('res/home'); ?>/css/theme.css" rel="stylesheet">
        <!-- main site css file -->    
        <link href="<?php echo base_url('res/home'); ?>/style.css" rel="stylesheet">


        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- =========================
          //////////////This Theme Design and Developed //////////////////////
          //////////// by www.wpfreeware.com======================-->

        <!-- Preloader -->
        <div id="preloader">
            <div id="status">&nbsp;</div>
        </div>
        <!-- End Preloader -->

        <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>

        <div class="container">
            <!-- start header section -->
            <header id="header">    
                <?php $this->load->view('home/topmenu'); ?>
            </header><!-- End header section --> 
            <!-- start nav section --> 
            <section id="navArea">
                <!-- Start navbar -->
                <nav class="navbar navbar-inverse" role="navigation">      
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>          
                    </div>
                    <?php $this->load->view('home/menu'); ?>
                    <!--/.nav-collapse -->      
                </nav>
            </section><!-- End nav section -->

            <?php $this->load->view('home/newfeed'); ?>

            <!-- start slider section -->
            <section id="sliderSection">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8">
                        <!-- Set up your HTML -->
                        <?php $this->load->view('home/slide'); ?>
                    </div>
                    <?php $this->load->view('home/lasterpost'); ?>
                </div>
            </section><!-- End slider section -->
            <!-- =========================
             //////////////This Theme Design and Developed //////////////////////
             //////////// by www.wpfreeware.com======================-->

            <!-- ==================start content body section=============== -->

            <?php if ($this->router->class == 'home'): ?>
                <?php if ($this->router->fetch_method() == 'index'): ?>
                    <?php $this->load->view('home/content'); ?>
                <?php endif; ?> 
                <?php if ($this->router->fetch_method() == 'details'): ?>
                    <?php $this->load->view('home/details'); ?>
                <?php endif; ?> 
            <?php endif; ?>
            <!-- ==================End content body section=============== -->    
            <?php $this->load->view('home/footer'); ?>
        </div> <!-- /.container -->


        <!-- jQuery Library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
        <!-- For content animatin  -->
        <script src="<?php echo base_url('res/home'); ?>/js/wow.min.js"></script>
        <!-- bootstrap js file -->
        <script src="<?php echo base_url('res/home'); ?>/js/bootstrap.min.js"></script> 
        <!-- slick slider js file -->
        <script src="<?php echo base_url('res/home'); ?>/js/slick.min.js"></script> 
        <!-- news ticker jquery file -->
        <script src="<?php echo base_url('res/home'); ?>/js/jquery.li-scroller.1.0.js"></script>
        <!-- for news slider -->
        <script src="<?php echo base_url('res/home'); ?>/js/jquery.newsTicker.min.js"></script>
        <!-- for fancybox slider -->
        <script src="<?php echo base_url('res/home'); ?>/js/jquery.fancybox.pack.js"></script>
        <!-- custom js file include -->    
        <script src="<?php echo base_url('res/home'); ?>/js/custom.js"></script> 


        <!-- =========================
              //////////////This Theme Design and Developed //////////////////////
              //////////// by www.wpfreeware.com======================-->


    </body>
</html>