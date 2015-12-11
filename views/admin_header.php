<!DOCTYPE html>
<html lang="en">
    <head>        
        <!-- META SECTION -->
        <title>Admin</title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- END META SECTION -->

        <!-- FAVICON -->
        <link rel="icon" href="<?php echo base_url() . APPPATH; ?>images/favicon.png"/>
        <!-- END FAVICON -->

        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="<?php echo base_url() . APPPATH; ?>css/admin/theme-default.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/admin/layout.css"/>
        <!-- EOF CSS INCLUDE -->      
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/plugins/jquery/jquery.min.js"></script>
    </head>
    <body>
        <!-- START PAGE CONTAINER -->
        <div class="page-container">

            <!-- START PAGE SIDEBAR -->
            <div class="page-sidebar">
                <!-- START X-NAVIGATION -->
                <ul class="x-navigation">
                    <li class="xn-logo">
                        <?php echo anchor('admin/index','<img src="' . base_url() . APPPATH . '"images/logo.png"/>') ;?>
                        <a href="#" class="x-navigation-control"></a>
                    </li>
                    <li class="xn-profile">
                        <a href="#" class="profile-mini">
                            <img src="<?php echo base_url() . APPPATH . "images/$user->profielfoto"; ?>" alt="<?php echo $user->voornaam . ' ' . $user->achternaam; ?>"/>
                        </a>
                        <div class="profile">
                            <div class="profile-image">
                                <img src="<?php echo base_url() . APPPATH . "images/$user->profielfoto"; ?>" alt="<?php echo $user->voornaam . ' ' . $user->achternaam; ?>"/>
                            </div>
                            <div class="profile-data">
                                <div class="profile-data-name"><?php echo $user->voornaam . ' ' . $user->achternaam; ?></div>
                                <div class="profile-data-title"><?php echo $user->niveau->naam; ?></div>
                            </div>
                            
                        </div>                                                                        
                    </li>
                    <li class="xn-title">Navigation</li>
                    <li>
                        <?php echo anchor('admin/index', '<span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span>');?>                      
                    </li>                    
                    <li>
                        <?php echo anchor('manage/profiles', '<span class="fa fa-user"></span> <span class="xn-text">Users</span>');?>   
                    </li> 
                    <li>
                        <a href="#"><span class=""></span> <span class="xn-text"></span></a>
                    </li>
                    <?php if ($this->session->userdata('managing_conference') != null) { ?>
                    <li class="xn-title">Management</li>
                    <li>
                        <?php echo anchor('conference/manage/' . $this->session->userdata('managing_conference'), '<span class="fa fa-thumb-tack"></span> <span class="xn-text">Overview</span>');?>   
                    </li>     
                    <li>
                        <?php echo anchor('manage/hotels', '<span class="fa fa-home"></span> <span class="xn-text">Hotels</span>');?>   
                    </li>                   
                    <li>
                        <?php echo anchor('manage/rooms', '<span class="fa fa-group"></span> <span class="xn-text">Rooms</span>');?>   
                    </li>   
                    <li>
                        <?php echo anchor('manage/pricing', '<span class="fa fa-eur"></span> <span class="xn-text">Pricing</span>');?>   
                    </li>   
                    <li>
                        <?php echo anchor('manage/stats', '<span class="fa fa-bar-chart-o"></span> <span class="xn-text">Stats</span>');?>  
                    </li>                    
                    <li>
                        <?php echo anchor('manage/downloads', '<span class="fa fa-download"></span> <span class="xn-text">Downloads</span>');?>  
                    </li>                    
                    <li>
                        <?php echo anchor('manage/announcements', '<span class="fa fa-comment"></span> <span class="xn-text">Announcements</span>');?>  
                    </li>
                    <li>
                        <?php echo anchor('manage/schedule', '<span class="fa fa-clock-o"></span> <span class="xn-text">Schedule</span>');?>  
                    </li>
                    <li>
                        <?php echo anchor('manage/proposals', '<span class="fa fa-file"></span> <span class="xn-text">Proposals</span>');?>  
                    </li>
                    <?php } ?>
                </ul>
                <!-- END X-NAVIGATION -->
            </div>
            <!-- END PAGE SIDEBAR -->

            <!-- PAGE CONTENT -->
            <div class="page-content">

                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                    <!-- TOGGLE NAVIGATION -->
                    <li class="xn-icon-button">
                        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                    </li>
                    <!-- END TOGGLE NAVIGATION -->
                    
                    <!-- SIGN OUT -->
                    <li class="xn-icon-button pull-right">
                        <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>                        
                    </li> 
                    <!-- END SIGN OUT -->
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->                     

                 
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-3">

                            <!-- START WIDGET SLIDER -->
                            <div class="widget widget-default widget-carousel">
                                <div class="owl-carousel" id="owl-example">
                                    <div>                                    
                                        <div class="widget-title">New</div>
                                        <div class="widget-subtitle">Visitors</div>
                                        <div class="widget-int">1,977</div>
                                    </div>
                                </div>                                                      
                            </div>         
                            <!-- END WIDGET SLIDER -->

                        </div>
                        <div class="col-md-3">

                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-envelope"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count">48</div>
                                    <div class="widget-title">New messages</div>
                                    <div class="widget-subtitle">In your mailbox</div>
                                </div>      
                            </div>                            
                            <!-- END WIDGET MESSAGES -->

                        </div>
                        <div class="col-md-3">

                            <!-- START WIDGET REGISTRED -->
                            <div class="widget widget-default widget-item-icon">
                                <div class="widget-item-left">
                                    <span class="fa fa-user"></span>
                                </div>
                                <div class="widget-data">
                                    <div class="widget-int num-count"><?php echo $countUsers; ?></div>
                                    <div class="widget-title">Registered users</div>
                                    <div class="widget-subtitle">On your website</div>
                                </div>                           
                            </div>                            
                            <!-- END WIDGET REGISTRED -->

                        </div>
                        <div class="col-md-3">

                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-danger widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>                            
                                <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="#"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>                            
                            </div>                        
                            <!-- END WIDGET CLOCK -->

                        </div>
                    </div>
                    <!-- END WIDGETS -->   
