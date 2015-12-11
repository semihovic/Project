
<?php // include APPPATH . "views/layout/header.php"; ?>
<?php //include APPPATH . "views/layout/footer.php"; ?> 

<!-- dit is voor de banner. Dit moet in de content want de banner moet niet op elke pagina worden weergegeven!
-->

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
<?php
?>
<!--<p>&nbsp;</p>
<p>&nbsp;</p>-->
<!--<div id="title">
        <h1> IC Clear </h1>
        <p> Promoting plain language<sup><a href="" id="infoKlik">*</a></sup> </p>
</div>-->

<div class="row">
    <div class="col-lg-12">
<div class="block-heading this-animate" data-animate="fadeInLeft">
                            <h2>Welcome</h2>
                            <div class="block-heading-text">
                               Clarity and IC Clear jointly hosted the 2014 Clarity conference. It provided a unique opportunity for clear communication professionals and plain language experts from around the world to showcase their best teaching and learning practices. The focus was on the latest initiatives and research in clear communication in both the public and the private sector and emphasised legal language as a prime example. The conference was held in two exciting historical cities: Antwerp on 12 and 13 November and Brussels on 14 November. In Brussels, participants had the opportunity to meet with the European Commission’s clear communication experts.
    </div>
</div>
 


        <h1 class="page-header"><font color="black">
            Announcements</font>
        </h1>

<?php foreach ($aankondigingen as $aankondiging) { 
    $om = $aankondiging->beschrijving;
    $omsch = substr( $om, 0 , 350); ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4><?php echo $aankondiging->titel . "</h4><h6>Conference: " . $aankondiging->conferentie->naam; ?></h6>
            </div>
        <div class="panel-body  nieuws">
        <p><?php echo $omsch . '...'; ?></p>
        </div>
            <div class="panel-footer">
            &nbsp;<?php echo anchor("conference/schedule/" . $aankondiging->conferentie->id, "<div class='btn btn-primary'>Learn more</div>"); ?>
        </div>
            </div>
        </div>
<?php } ?>
</div>
<!-- /.row -->



<!-- jssor slider scripts-->
<!-- use jssor.js + jssor.slider.js instead for development -->
<!-- jssor.slider.mini.js = (jssor.js + jssor.slider.js) -->
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>





<?php
// include APPPATH . "views/layout/footer.php";?>