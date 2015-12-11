
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Stats</h3>
                    <span>All stats of the conference <?php echo $conference->naam; ?></span>
                </div>                                     
            </div>

        </div>
    </div>


</div>

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <!-- START WIDGETS -->                    
    <div class="row">
        <div class="col-md-4">

            <!-- START WIDGET SLIDER -->
            <div class="widget widget-default widget-carousel">
                <div class="owl-carousel" id="owl-example">
                    <div>                                    
                        <div class="widget-title">Participants</div>
                        <div class="widget-subtitle"><?php echo $conference->naam; ?></div>
                        <div class="widget-int"><?php echo $participants->deelnemers; ?></div>
                    </div>
                </div>                                                      
            </div>         
            <!-- END WIDGET SLIDER -->

        </div>
        <div class="col-md-4">

            <!-- START WIDGET MESSAGES -->
            <div class="widget widget-default widget-item-icon">                            
                <div class="widget-data">
                    <div class="widget-title">Pending Payments</div>
                    <div class="widget-subtitle"><?php echo $conference->naam; ?></div>
                    <div class="widget-int num-count"><?php if (!empty($pendingPayment)) { echo $pendingPayment->prijs; } else { echo "0"; } ?></div>
                </div>      
            </div>                            
            <!-- END WIDGET MESSAGES -->

        </div>
        <div class="col-md-4">

            <!-- START WIDGET REGISTRED -->
            <div class="widget widget-default widget-item-icon">
                <div class="widget-data">
                    <div class="widget-title">Paid Payments</div>
                    <div class="widget-subtitle"><?php echo $conference->naam; ?></div>
                    <div class="widget-int num-count"><?php if (!empty($paidPayment)) { echo $paidPayment->prijs; } else { echo "0"; } ?></div>
                </div>                           
            </div>                            
            <!-- END WIDGET REGISTRED -->

        </div>
    </div>
    <!-- END WIDGETS -->  
</div>
<!-- END PAGE CONTENT WRAPPER -->
