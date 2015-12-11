
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Sessions</h3>
                    <?php
                    if (empty($session)) {
                        $datumExplode = explode('-', $conferenceDay->datum);
                    } else {
                        $datumExplode = explode('-', $session->conferentieDag->datum);
                    }
                    ?>
                    <span>Sessions for the conference <b><?php echo $conference->naam; ?></b> on day <b><?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?></b></span>
                </div>  
            </div>
            <div class="panel-body panel-body-table">     
                <div class="table-responsive">
                    <?php echo form_open("session/modifyConfirm", array("id" => "modifyConfirmForm")); ?>

                    <table class="table table-bordered table-condensed">

                        <?php
                        if (empty($session)) {
                            echo form_hidden('id', 0);
                            echo form_hidden('conferenceDayId', $conferenceDay->id);
                        } else {
                            echo form_hidden('id', $session->id);
                            echo form_hidden('conferenceDayId', $session->conferentieDag->id);
                        }
                        ?>
                        <tr>
                            <th><?php echo form_label('Name','name');?></th>
                            <td class="row">
                                <span class="col-md-6">
                                <?php
                                if (!empty($session)) {
                                    echo form_input(array("name" => "name", "value" => $session->naam, "required" => "required", 'class' => 'form-control'));
                                } else {
                                    echo form_input(array("name" => "name", "value" => "", "required" => "required", 'class' => 'form-control'));
                                }
                                ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo form_label('Start Time','starttime');?></th>
                            
                            <td class="row">
                                <span class="col-md-6">
                                    <?php if (!empty($session)) { 
                                        echo form_input(array("value" => $session->beginuur, "name" => "starttime", "required" => "required", "type" => "time", "id" => "starttime", 'class' => 'form-control'));
                                    } else {
                                        echo form_input(array("name" => "starttime", "required" => "required", "type" => "time", "id" => "starttime", 'class' => 'form-control'));
                                    } ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo form_label('End Time','endtime');?></th>
                            <td class="row"> 
                                <span class="col-md-6">
                                    <?php if (!empty($session)) { 
                                        echo form_input(array("value" => $session->einduur, "name" => "endtime", "required" => "required", "type" => "time", "id" => "endtime", 'class' => 'form-control'));
                                    } else {
                                        echo form_input(array("name" => "endtime", "required" => "required", "type" => "time", "id" => "endtime", 'class' => 'form-control'));
                                    } ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo form_label('Description','description');?></th>
                            <td class="row">
                                <span class="col-md-6">
                                    <?php
                                    if (!empty($session)) {
                                        echo form_textarea(array("name" => "description", "value" => $session->beschrijving, "required" => "required", 'class' => 'form-control'));
                                    } else {
                                        echo form_textarea(array("name" => "description", "value" => "", "required" => "required", 'class' => 'form-control'));
                                    }
                                    ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo form_label('Room','room');?></th>
                            <td class="row">
                                <span class="col-md-6">
                                    <?php
                                    if (empty($session)) {
                                        $roomDropDown[""] = "Select a room";
                                    }
                                    foreach ($rooms as $room) {
                                        $roomDropDown[$room->id] = $room->naam;
                                    }
                                    if (!empty($session)) {
                                        echo form_dropdown('room', $roomDropDown, $session->id, 'required class="form-control"');
                                    } else {
                                        echo form_dropdown('room', $roomDropDown, '', 'required class="form-control"');
                                    }
                                    ?> 
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th><?php echo form_label('Speakers','speakers[]');?></th>
                            <?php
                            if (empty($session)) {
                                $speakersDropDown[""] = "Select a speaker";
                            }
                            foreach ($speakers as $speaker) {
                                $speakersDropDown[$speaker->id] = $speaker->voornaam . " " . $speaker->achternaam;
                            }
                            ?>
                            <td class="row speakerTd">
                                <span class="row"><a href="#" class="addSpeakerDropDown">Add Speaker</a></span> 
                                <span class="speakerP"> 
                                    <?php $id = 0;
                                    if (!empty($session)) {
                                        if (!empty($session->gegevenDoor)) {
                                            ?>
                                            <?php foreach ($session->gegevenDoor as $gegevenDoor) { 
                                                if ($gegevenDoor->deelnemer->id >= $id) {
                                                 $id = $gegevenDoor->deelnemer->id; 
                                                } ?>
                                                    <span class="row">
                                                        <span class="dropDown<?php echo $gegevenDoor->deelnemer->id;?> col-md-6"><?php echo form_dropdown('sprekers[]', $speakersDropDown, $gegevenDoor->deelnemer->id, 'required class="form-control"'); ?></span>
                                                        <span class="col-md-1 dropDown<?php echo $gegevenDoor->deelnemer->id;?>"> <a href="#" class="deleteSpeakerDropDown pull-right" data-id="<?php echo $gegevenDoor->deelnemer->id;?>">Delete</a></span>
                                                    </span>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } else { ?>
                                                    <span class="row">
                                                        <span class="dropDown0 col-md-6"><?php echo form_dropdown('sprekers[]', $speakersDropDown, '', 'required class="form-control"'); ?> </span>
                                                    </span>
                                    <?php } ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo form_submit(array('name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-warning')); ?></td>
                            <td><a href="javascript:window.history.go(-1);" class="btn btn-warning">Cancel</a></td>
                        </tr>
                    </table>
                    <?php echo form_close(); ?>
                </div>    
            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>

<script>
    $(document).ready(function () {
        var idThroughPHP = "<?php echo $id;?>";
        $(".deleteSpeakerDropDown").click(function(e) {
            e.preventDefault();
            $("span.dropDown" + $(this).data("id")).remove();
        });
            
        $(".addSpeakerDropDown").click(function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url() ?>/ajax/addSpeakerDropdown",
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    idThroughPHP = parseInt(idThroughPHP) + 1;
                    var dropdown = '<span class="row"><span class="dropDown' + idThroughPHP + ' col-md-6"><select name="sprekers[]" required class="form-control"><option value="">Select a speaker</option>';
                    for (var i = 0; i < object.length; i++) {
                        dropdown += '<option value="' + object[i].id + '">' + object[i].voornaam + ' ' + object[i].achternaam + '</option>';
                    }
                    dropdown += '</select></span><span class="col-md-1 dropDown' + idThroughPHP + '"><a href="#" class="deleteSpeakerDropDown" data-id="' + idThroughPHP + '">Delete</a></span>';
                    $("span.speakerP").html($("span.speakerP").html() + "\n" + dropdown);
                    deleteDropDown();
                }
            });
        });
        
        function deleteDropDown() {
            $(".deleteSpeakerDropDown").click(function(e) {
                e.preventDefault();
                $("span.dropDown" + $(this).data("id")).remove();
            });
        }
                
        $("#modifyConfirmForm").submit(function(e) {
            //start time
            var start_time = $("#starttime").val();

            //end time
            var end_time = $("#endtime").val();

            //convert both time into timestamp
            var stt = new Date("November 13, 2013 " + start_time);
            stt = stt.getTime();

            var endt = new Date("November 13, 2013 " + end_time);
            endt = endt.getTime();

            if(stt > endt) {
                e.preventDefault();
                alert("End time must be at a later time than the begin time.");
            }
        });
    });
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->


