
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>
<script>
    $(document).ready(function () {
        var ids = <?php echo json_encode($conferentieDagen);?>;
        $('.sessieHide').hide();
        $('.dagId').click(function (e) {
            e.preventDefault();
            //$('.sessieHide').hide();
            $('.sessieHide').html('');
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/ajax/checkSchedule",
                data: {conferentieDagId: $(this).data('id')},
                success: function (result) {
                    var isVisible = true;
                    var object = jQuery.parseJSON(result);
                    if ($('.sessie' + object[0].conferentieDagId).is(":visible")) {
                        isVisible = false;
                        $('.sessie' + object[0].conferentieDagId).hide();
                    } else {
                        for (i = 0; i < ids.length; i++) {
                            $('.sessie' + ids[i].id).hide();
                        }      
                    }
                    if (isVisible === true) {
                        var inhoud = "<table class=\"table table-striped\">";
                        inhoud += "<tr> \n\
                                    <th>Name</th>\n\
                                    <th>Speaker(s)</th>\n\
                                    <th>Start</th> \n\
                                    <th>End</th> \n\
                                    <th>Summary</th> \n\
                                    <th>Room</th> \n\
                                    \n\
                              </tr>";
                        for (i = 0; i < object.length; i++) {
                            inhoud += "<tr> \n\
                                        <td>" + object[i].naam + "</td> \n\
                                        <td>";
                            for (j = 0; j < object[i].gegevenDoor.length; j++) {
                                inhoud += "<p>" + object[i].gegevenDoor[j].deelnemer.voornaam + " " + object[i].gegevenDoor[j].deelnemer.achternaam + "</p>";
                            }
                            inhoud += "</td> \n\
                                        <td>" + object[i].beginuur + "</td>  \n\
                                        <td>" + object[i].einduur + "</td> \n\
                                        <td>" + object[i].beschrijving + "</td> \n\
                                        <td>" + object[i].lokaal.naam + "</td> \n\
                                        \n\
                                    </tr>";

                        }
                        inhoud += "\n</table>\n";
                        $('.sessie' + object[0].conferentieDagId).show();
                        $('.sessie' + object[0].conferentieDagId).html(inhoud);
                    }

                }
            });
        });
    });
</script>

<h1><?php echo $conferentie->naam; ?></h1>
<?php // foreach ($conferentieDagen as $dag) { ?>
<?php // $datumExplode = explode('-', $dag->datum); ?>
<?php // echo "<p><a  href='#' class='dagId' data-id='" . $dag->id . "'>" . date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])) . "</a></p>\n"; ?>
<?php // echo '<p class="sessieHide sessie' . $dag->id . '"></p>'; ?>
<?php // echo "\n"; ?>
<?php // }   ?>


<?php // } ?>
<div class="panel tabs">
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#information" data-toggle="tab">Information</a></li>
        <li><a href="#sessions" data-toggle="tab">Schedule</a></li>
        <li><a href="#activities" data-toggle="tab">Activities</a></li>
        <li><a href="#speakers" data-toggle="tab">Speakers</a></li>
        <li><a href="#hotels" data-toggle="tab">Hotels</a></li>
        <li><a href="#downloads" data-toggle="tab">Downloads</a></li>
    </ul>
    <div class="panel-body tab-content">
        <div class="tab-pane active" id="information">
            <?php
            $startExplode = explode('-', $conferentie->startdatum);
            $eindExplode = explode('-', $conferentie->einddatum);
            ?>
            
            <table class="table">
                <tr>
                    <th>Starts: </th>
                    <td><?php echo date('d F Y', mktime(0, 0, 0, $startExplode[1], $startExplode[2], $startExplode[0])); ?></td>
                </tr>
                <tr>
                    <th>Ends: </th>
                    <td><?php echo date('d F Y', mktime(0, 0, 0, $eindExplode[1], $eindExplode[2], $eindExplode[0])); ?></td>
                </tr>
                <tr>
                    <th>Location: </th>
                    <td><?php echo $conferentie->locatie->naam; ?></td>
                </tr>
                <th>Extra information: </th>
                <td><?php echo $conferentie->extraInfo; ?></td>
                </tr>
            </table>
            
        </div>
        <div class="tab-pane" id="sessions">
            <?php
            if (count($conferentieDagen) != 0) {
                foreach ($conferentieDagen as $dag) {
                    ?>
                    <?php $datumExplode = explode('-', $dag->datum); ?>
                    <?php echo "<h4 class='panel-title'><a  href='#' class='dagId' data-id='" . $dag->id . "'>" . date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])) . " <span class=\"fa fa-angle-double-down\"></span></a></h4>\n"; ?>
                    <?php echo '<p class="sessieHide sessie' . $dag->id . '"></p>'; ?>
                    <?php echo "\n"; ?>
                    <?php
                }
            } else {
                echo "<p>There are no sessions scheduled during this conference.</p>";
            }
            ?>
        </div>
        <div class="tab-pane" id="activities">
            <?php if (count($conferentieDagen) != 0) { ?>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Starts</th>
                        <th>Ends</th> 
                    </tr>
                    <?php
                    foreach ($conferentieDagen as $dag) {
                        foreach ($dag->activiteiten as $activiteit) {
                            $datumExplode = explode('-', $dag->datum);
                            ?>
                            <tr>
                                <td><?php echo $activiteit->naam; ?></td>
                                <td><?php echo date('d F Y ', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])) ?></td>
                                <td><?php echo $activiteit->beginuur; ?></td>
                                <td><?php echo $activiteit->einduur; ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
                <?php
            } else {
                echo "<p>There are no activities scheduled during this conference.</p>";
            }
            ?>
        </div>
        <div class="tab-pane" id="hotels">
            <?php
            if (count($hotels) != 0) {
                foreach ($hotels as $hotel) {
                    ?>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body profile">
                                <h4><?php echo $hotel->naam; ?> </h4>


                                <p>Address: <?php echo $hotel->adres; ?> </p>

                                <p>Location: <?php echo $hotel->plaats; ?> </p>

                                <p>Phone number: <?php echo $hotel->telefoon; ?> </p>
                                <p>Price per night: <?php echo $hotel->prijsPerNacht; ?> euro </p>
                                <p>Website: <?php echo anchor($hotel->website, $hotel->website); ?> </p>
                            </div> 
                        </div>

                    </div>
                    <?php
                }
            } else {
                echo "<p>There are no hotels yet for this conference.</p>";
            }
            ?>
        </div>
        <div class="tab-pane" id="speakers">
            <?php
            if (count($hotels) != 0) {
                foreach ($speakers as $speaker) {
                    ?>
                    <div class="col-md-3">
                        <div class="panel panel-default">
                            <div class="panel-body profile">
                                <h4><?php echo $speaker->voornaam . " " . $speaker->achternaam ?> </h4>
                            </div> 
                        </div>

                    </div>
                    <?php
                }
            } else {
                echo "<p>There are no speakers yet for this conference.</p>";
            }
            ?></div> 
        <div class="tab-pane" id="downloads">
            <?php
            if (count($hotels) != 0) {?>
                <table class="table table-striped">
                    <tr>
                        <th>Title</th>
                        <th>Document</th>
                    </tr>
                <?php foreach ($downloads as $download) {
                    ?>
                    <tr>
                        <td><?php echo $download->titel;?></td>
                        <td><a href="<?php echo base_url(); ?>upload/files/<?php echo $download->upload; ?>" target="_blank"><?php echo $download->upload; ?></td>
                    </tr>
                    <?php
                }?>
                </table>
                <?php
            } else {
                echo "<p>There are no downloads yet for this conference.</p>";
            }
            ?>
        </div>
    </div>
</div>      


<p> Would you like to attend this conference? </p>
<p> Click on Attend and follow the steps. Please keep in mind that you have to be registered in order to log in.<p>
<p> <?php echo anchor('conference/sign/' . $conferentie->id, 'Attend', array('class' => 'btn btn-primary')); ?> <?php echo anchor('conference/index/', 'Back', array('class' => 'btn btn-primary')); ?></p>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>
