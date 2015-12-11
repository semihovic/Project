<?php foreach($datas as $data) { ?>
<p> <?php echo $data->conferentieDag->conferentie->naam;?>: <?php echo $data->datum;?> </p>
<?php } ?>
