
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Sessions</h3>
                    <?php $datumExplode = explode('-', $conferenceDay->datum); ?>
                    <span>Sessions of day <?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?> from the conference <?php echo $conference->naam; ?></span>
                </div>  
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><?php echo anchor('session/add/' . $conferenceDay->id, '<span class="fa fa-plus"></span>'); ?></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">     
                <?php if (!empty($sessions)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Room</th>
                                    <th>Speaker(s)</th>
                                    <th width="20%" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sessions as $session) { ?>
                                    <tr>
                                        <td><?php echo $session->beginuur; ?></td>
                                        <td><?php echo $session->einduur; ?></td>
                                        <td><?php echo $session->naam; ?></td>
                                        <td><?php echo $session->beschrijving; ?></td>
                                        <td><?php echo $session->lokaal->naam; ?></td>
                                        <td>
                                            <?php if (!empty($session->gegevenDoor)) { ?>
                                                <?php foreach ($session->gegevenDoor as $gegevendoor) { ?>
                                                    <p><?php echo $gegevendoor->deelnemer->voornaam; ?> <?php echo $gegevendoor->deelnemer->achternaam; ?></p>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <p> No speakers found. </p>
                                            <?php } ?>
                                        </td>
                                        <td class="actioncol"><?php echo anchor('session/modify/' . $session->id, 'Modify'); ?></td>
                                        <td class="actioncol"><?php echo anchor('session/delete/' . $session->id, 'Delete', array('onclick' => 'return myFunction();')); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>
                    <p> No sessions for this day. </p>
                <?php } ?>     

            </div>
        </div>
        <p>&nbsp;</p>
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Activities</h3>
                    <span>Activities of day <?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?> from the conference <?php echo $conference->naam; ?></span>
                </div>  
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><?php echo anchor('activity/add/' . $conferenceDay->id, '<span class="fa fa-plus"></span>'); ?></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">     
                <?php if (!empty($activities)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>Start time</th>
                                    <th>End time</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th width="20%" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($activities as $activity) { ?>
                                    <tr>
                                        <td><?php echo $activity->beginuur; ?></td>
                                        <td><?php echo $activity->einduur; ?></td>
                                        <td><?php echo $activity->naam; ?></td>
                                        <td>€<?php echo $activity->prijs; ?></td>
                                        <td class="actioncol"><?php echo anchor('activity/modify/' . $activity->id, 'Modify'); ?></td>
                                        <td class="actioncol"><?php echo anchor('activity/delete/' . $activity->id, 'Delete', array('onclick' => 'return myFunction2();')); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>
                    <p> No activities for this day. </p>
                <?php } ?>     

            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>

<script>
        function myFunction() {
        var r = confirm("Are you sure you want to delete this session?");
            if (r == true) {
        return true;
            } else {
        return false;
    }
    }
    
        function myFunction2() {
        var r = confirm("Are you sure you want to delete this activity?");
            if (r == true) {
        return true;
            } else {
        return false;
    }
    }
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->


