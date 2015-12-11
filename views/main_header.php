<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- META SECTION -->
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- END META SECTION -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/styles.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/styles_nav.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/nav.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/tiles/tiles.css" media="screen" />


        <!-- FAVICON -->
        <link rel="icon" href="<?php echo base_url() . APPPATH; ?>images/favicon.png"/>
        <!-- END FAVICON -->

        <!-- NAV FIXES -->

        <!-- SCRIPTS -->
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/bootstrap/bootstrap.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/tiles.js"></script>

        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/mixitup/jquery.mixitup.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/appear/jquery.appear.js"></script>

        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/revolution-slider/jquery.themepunch.tools.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/revolution-slider/jquery.themepunch.revolution.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/actions.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/slider.js"></script>
        <script src="<?php echo base_url() . APPPATH; ?>js/frontend/nav.js"></script>

    </head>
    <body>

        <?php
        if($user == null){
            $navwidth = "nouser";
        }
        else {
            $navwidth = "user";
            if($user->niveauId == 1)
            {
                $subnavlength = "admin";
            }else{
                $subnavlength = "speaker";
            }
            
            
        }
        
        
        ?>



        <div class="container">
            <header class="bg-darken-gray">
                <nav>
                    <div id="hwrapper" >
                        <?php $img = array('src' => APPPATH . 'images/logo.png', 'alt' => 'logo IC Clear', 'height' => 65); ?>
                        <div class="logo"><?php echo anchor('home/index', img($img)); ?></div>
                        <div id="navbutton">
                            <a href="#"></a>
                        </div>
                        <div class="nav <?php echo $navwidth; ?>">
                            <ul>
                                <?php
                                echo "<li>" . anchor('home/index', 'Home') . "</li>";
                                echo "<li>" . anchor('conference/index', 'Conferences') . "</li>";
                                if ($user != null) {
                                    echo "<li>" . anchor('http://icclear.freeforums.org/index.php', 'Community') . "</li>";
                                }
                                echo "<li>" . anchor('contact/index', 'Contact') . "</li>";
                                

                                if ($user == null) {
                                    echo "<li>" . anchor('home/login', 'Login') . "</li>";
                                } else {
                                    $img2 = array('src' => APPPATH . "images/$user->profielfoto", 'height' => 40, 'alt' => 'Avatar');
                                    echo "<li id='user'>" . anchor('profile/index', img($img2) . "$user->voornaam $user->achternaam") . "</li>";
                                    
                                }

//                                <?php
//                                foreach ($nav as $name => $href) {
//                                    echo "<li><a href='" . site_url() . "/" . $href . "'>" . $name . "</a></li>\n\t\t\t";
//                                }
                                ?>
                                <?php
//                                if (count($user) != 0) {
//                                     $img2 = array('src' => APPPATH . "images/$user->profielfoto", 'height' => 40, 'alt' => 'Avatar');
//                                    echo "<li id='user'>" . anchor('user/aanpassen', img($img2) . "$user->voornaam $user->achternaam") . "</li>";
//                                }
//                                
                                ?>
                            </ul>
                        </div>
                        <?php
                        if (count($user) != 0) {
                            echo '<div class="subnav ' . $subnavlength . '">' ;
                            echo '<ul>';
                            echo "<li>" . anchor('profile/index', 'My Profile') . "</li>";
                            if($user->niveauId == 1){
                                echo "<li>" . anchor('admin/index', 'Manage') . "</li>";
                            }
                            
                            
                                echo "<li>" . anchor('home/speakerRequest', 'My subjects') . "</li>";
                            
                            echo "<li>" . anchor('home/logout', 'Logout') . "</li>";
                            echo "</ul></div>";
                        }
                        ?>
                    </div>
                </nav>
            </header>

            <!-- page content -->
            
                        <div style="min-height: 50px;">
        <!-- Jssor Slider Begin -->
        <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
        <!-- ================================================== -->
        <div id="slider1_container" style="display: none; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 250px; overflow: hidden;">
            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
                <div style="position: absolute; display: block; background: url(<?php echo base_url() . APPPATH; ?>images/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
            </div>
            <!-- Slides Container -->
            <div u="slides" style=" position: absolute; left: 0px; top: 0px; width: 1300px; height: 250px; overflow: hidden;">
                <div>
                    <img  u="image" src2="<?php echo base_url() . APPPATH; ?>images/blue.png" />
                </div>
                <div>
                    <img style="cursor: pointer;" onclick="location.href = 'speakerRequest'" u="image" src2="<?php echo base_url() . APPPATH; ?>images/red.png" />
                </div>
            </div>
            
            <!--#region Bullet Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/development/slider-with-bullet-navigator-jquery.html -->
            <style>
                /* jssor slider bullet navigator skin 21 css */
                /*
                .jssorb21 div           (normal)
                .jssorb21 div:hover     (normal mouseover)
                .jssorb21 .av           (active)
                .jssorb21 .av:hover     (active mouseover)
                .jssorb21 .dn           (mousedown)
                */
                .jssorb21 {
                    position: absolute;
                    width:100%;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(<?php echo base_url() . APPPATH; ?>images/b21.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
                <!-- bullet navigator item prototype -->
                <div u="prototype"></div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->
            
            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
            <style>
                /* jssor slider arrow navigator skin 21 css */
                /*
                .jssora21l                  (normal)
                .jssora21r                  (normal)
                .jssora21l:hover            (normal mouseover)
                .jssora21r:hover            (normal mouseover)
                .jssora21l.jssora21ldn      (mousedown)
                .jssora21r.jssora21rdn      (mousedown)
                */
                .jssora21l, .jssora21r {
                    display: block;
                    position: absolute;
                    /* size of arrow element */
                    width: 55px;
                    height: 55px;
                    cursor: pointer;
                    background: url(<?php echo base_url() . APPPATH; ?>images/a21.png) center center no-repeat;
                    overflow: hidden;
                }
                .jssora21l { background-position: -3px -33px; }
                .jssora21r { background-position: -63px -33px; }
                .jssora21l:hover { background-position: -123px -33px; }
                .jssora21r:hover { background-position: -183px -33px; }
                .jssora21l.jssora21ldn { background-position: -243px -33px; }
                .jssora21r.jssora21rdn { background-position: -303px -33px; }
            </style>
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 65px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 65px; right: 8px;">
            </span>
            <!--#endregion Arrow Navigator Skin End -->
            <a style="display: none" href="http://www.jssor.com">Bootstrap Slider</a>
        </div>
        <!-- Jssor Slider End -->
    </div>
            
            <?php
            $page = $_SERVER['REQUEST_URI'];
            
            if($page == "/projecten/TI1415project25/project25/index.php/contact/index"){
               echo '<div id="google-map" style="width: 100%; height: 300px;"></div>';
            }
            ?>
            <div class="content">
                <!-- page content wrapper -->
                <div class="content-wrap">
                    <!-- page content holder -->
                    <div class="content-holder">