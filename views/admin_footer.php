</div>            
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>                    
                <p>Press 'No' if you want to continue work. Press 'No, leave admin' to go back to the home page. Press 'Yes' to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <?php echo anchor('home/logout','Yes',array('class' => "btn btn-success btn-lg"));?>
                    <?php echo anchor('home/index','No, leave admin',array('class' => "btn btn-default btn-lg"));?>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->
                
<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/bootstrap/bootstrap.min.js"></script>        
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->        
<script type='text/javascript' src='<?php echo base_url() . APPPATH; ?>js/admin/plugins/icheck/icheck.min.js'></script>        
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/scrolltotop/scrolltopcontrol.js"></script>

<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/morris/raphael-min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/morris/morris.min.js"></script>       
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/rickshaw/d3.v3.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/rickshaw/rickshaw.min.js"></script>
<script type='text/javascript' src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script type='text/javascript' src='<?php echo base_url() . APPPATH; ?>js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'></script>                
<script type='text/javascript' src='<?php echo base_url() . APPPATH; ?>js/admin/plugins/bootstrap/bootstrap-datepicker.js'></script>                
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/owl/owl.carousel.min.js"></script>                 

<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/moment.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins/daterangepicker/daterangepicker.js"></script>
<!-- END THIS PAGE PLUGINS-->        

<!-- START TEMPLATE -->
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/plugins.js"></script>        
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/actions.js"></script>

<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/admin/demo_dashboard.js"></script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->         
</body>
</html>






