<h1> Conferences </h1> 
                        <div class="row">
                            <div class="col-md-12 gallery-filter">
                                <div class="button-panel">
                                    <button data-filter="all" class="btn btn-primary filter">All</button>
                                    <?php
                                    foreach($landen as $land){
                                        if($land->conferenties != null){
                                            $landnaam = $land->naam;
                                            $landnaam2 = str_replace(" ", "-", $landnaam);
                                        ?>
                                    <button data-filter='.cat_<?php echo $landnaam2;?>' class='btn btn-primary filter'><?php echo $landnaam;?></button> 
                                   <?php }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
<div class="row mix-grid thumbnails">

<?php
foreach($landen as $land){ 
    if($land->conferenties != null){
        foreach($land->conferenties as $conferentie) {
        $startExplode = explode('-', $conferentie->startdatum);
        $eindExplode = explode('-', $conferentie->einddatum);
        $landnaam = $land->naam;
        $landnaam2 = str_replace(" ", "-", $landnaam);
        $afb = $landnaam2;
        if($afb != "Belgium" && $afb != "France" && $afb != "Germany"){
            $afb = "all";
        }
        ?>

                            <div class="col-md-4 col-xs-4 mix cat_all cat_<?php echo $landnaam2; ?>">
                                <a class="thumbnail-item">
                                    <img src="https://subversion.khk.be/projecten/TI1415project25/project25/application/assets/frontend/img/gallery/<?php echo $afb; ?>.png" alt="<?php echo $landnaam2; ?>"/>
                                    <div class="thumbnail-info">
                                        <p>Starts: <?php echo date('d F Y', mktime(0, 0, 0, $startExplode[1], $startExplode[2], $startExplode[0])); ?></p>
                                        <p>Ends: <?php echo date('d F Y', mktime(0, 0, 0, $eindExplode[1], $eindExplode[2], $eindExplode[0]));?></p>
                                        <?php $link = base_url() . "index.php/conference/schedule/" . $conferentie->id; ?>
                                        <button onclick="location.href='<?php echo $link; ?>'" class="btn btn-primary">More information</button>
                                        
                                    </div>                                                                        
                                </a>
                                <div class="thumbnail-data">
                                    <h5><?php echo $conferentie->naam; ?></h5>
                                    <p><?php echo $conferentie->locatie->naam; ?></p>
                                </div>
                            </div>
<?php 
        }
    }
}
        /*
foreach($landen as $land){ 
    if($land->conferenties != null){
    echo "<br class='clearfix' /><h2 class='land' id=" . $land->naam . ">" . $land->naam . "</h2>";
    echo "<div class='col3'>"; 
    foreach($land->conferenties as $conferentie) {
        $startExplode = explode('-', $conferentie->startdatum);
        $eindExplode = explode('-', $conferentie->einddatum);
        anchor("conference/schedule/" . $conferentie->id, "<div class='conf-tile'>");
        
        echo "<div>";
        echo "<p class='test'> <div class='tile tile-2xbig tile-10' ></p><br />";
        echo img(APPPATH . 'images/conf_logo.png');
        echo "<p class='test'>Title: " . $conferentie->naam . "</p>";
        echo "<p class='test'>Location: " . $conferentie->locatie->naam . "</p>";
        echo "<p class='test'>Address: " . $conferentie->locatie->adres . " , " . $conferentie->locatie->stad . "</p>";
        echo "<p class='test'>Start: " . date('l jS F Y ', mktime(0, 0, 0, $startExplode[1], $startExplode[2], $startExplode[0])) ."</p>";
        echo "<p class='test'>End: " . date('l jS F Y',mktime(0, 0, 0, $eindExplode[1], $eindExplode[2], $eindExplode[0])) . "</p></div></div></div>";
        //echo "<p>Extra info: " . $conferentie->extraInfo . "</p></div></div></div>";
     
    }
         */
    ?> 
</div>