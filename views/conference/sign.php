<link href='https://subversion.khk.be/projecten/TI1415project25/project25/application/css/admin/calendar/fullcalendar.css' rel='stylesheet' />
<link href='https://subversion.khk.be/projecten/TI1415project25/project25/application/css/admin/calendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='https://subversion.khk.be/projecten/TI1415project25/project25/application/js/admin/plugins/fullcalendar/moment.js'></script>
<script src='https://subversion.khk.be/projecten/TI1415project25/project25/application/js/admin/plugins/jquery/jquery.min.js'></script>
<script src='https://subversion.khk.be/projecten/TI1415project25/project25/application/js/admin/plugins/fullcalendar/fullcalendar.min.js'></script>

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>

<h1> Signing for a conference </h1>

            <?php
$startExplode = explode('-', $conference->startdatum);
$eindExplode = explode('-', $conference->einddatum);
?>
<p>You selected: <b><?php echo $conference->naam; ?></b></p>
<p>This conference begins: <b><?php echo date('jS F Y', mktime(0, 0, 0, $startExplode[1], $startExplode[2], $startExplode[0])); ?></b></p>
<p>This conference ends: <b><?php echo date('jS F Y', mktime(0, 0, 0, $eindExplode[1], $eindExplode[2], $eindExplode[0])); ?></b></p>

<p> &nbsp; </p>
<p> Select the boxes of which dates you'd like to attend the conference.  </p>
<p> Once you have decided which dates, press Submit and a pop-up with the possible payment methods will appear. </p>
<?php if (!empty($user)) { ?>
    <p class="warning"> <b>Since you are logged in, only days/activities where you have not yet signed in for, are shown.</b></p>
<?php } ?>

<?php echo form_open('conference/signin'); ?>
<h2>Days</h2>
<div class="table-responsive">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th>Attend</th>
                <th>Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($conferenceDays)) { ?>
                <?php foreach ($conferenceDays as $conferenceDay) { ?>
                    <?php $date = explode('-', $conferenceDay->datum); ?>
                    <tr>
                        <td><input type="checkbox" name="conferentieDagen[]" data-id="<?php echo $conferenceDay->id; ?>" class="checkboxDagen" id="conferentieDag<?php echo $conferenceDay->id; ?>" value="<?php echo $conferenceDay->id; ?>"/></td>
                        <td><?php echo date('jS F Y', mktime(0, 0, 0, $date[1], $date[2], $date[0])); ?></td>
                        <td>€<?php echo $conferenceDay->prijs; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td>No Days Found</td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
        </tbody>

    </table>
</div>

<h2>Activities</h2>
<div class="table-responsive">
    <table class="table table-condensed table-hover">
        <thead>
            <tr>
                <th>Attend</th>
                <th>Name</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Date</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($activities)) { ?>
                <?php foreach ($activities as $activity) { ?>
                    <tr>
                        <?php $date2 = explode('-', $activity->conferentieDag->datum); ?>
                        <td><input type="checkbox" name="activities[]" data-id="<?php echo $activity->id; ?>" class="checkBoxActivies" id="activity<?php echo $activity->id; ?>" value="<?php echo $activity->id; ?>"/></td>
                        <td><?php echo $activity->naam; ?></td>
                        <td><?php echo $activity->beginuur; ?></td>
                        <td><?php echo $activity->einduur; ?></td>
                        <td><?php echo date('jS F Y', mktime(0, 0, 0, $date2[1], $date2[2], $date2[0])); ?></td>

                        <td>€<?php echo $activity->prijs; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <td>No Activities Found</td>
                <td></td>
                <td></td>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php echo form_hidden('prijsTotaal', 0); ?>

<?php echo form_submit(array('name' => 'submit', 'value' => 'Confirm', 'class' => 'btn btn-primary')); ?>

<?php echo form_close(); ?>

<div class="row">
    <div class="col-md-12">
        <h3 class="pull-right">Total Price: <b>€<span class="prijsTotaal">0</span></b></h3>
    </div>
</div>


<script>
    $(document).ready(function () {
        var prijs = parseInt($('.prijsTotaal').html());
        $('.checkboxDagen').click(function () {
            var dagId = $(this).data("id");

            $.ajax({type: "POST",
                url: "<?php echo site_url(); ?>/ajax/adjustPrice",
                data: {dagId: dagId},
                success: function (result) {

                    var object = jQuery.parseJSON(result);
                    var prijsOmhoog = false;
                    if ($('#conferentieDag' + object.id).prop('checked')) {
                        prijsOmhoog = true;
                    }

                    var newPrijs = parseInt(object.prijs);
                    if (prijsOmhoog) {
                        prijs = prijs + newPrijs;
                    } else {
                        prijs = prijs - newPrijs;
                    }
                    $(".prijsTotaal").html(prijs);
                    $("input[name='prijsTotaal']").val(prijs);
                }
            });
        });

        $('.checkBoxActivies').click(function () {
            var activityId = $(this).data("id");
            $.ajax({type: "POST",
                url: "<?php echo site_url(); ?>/ajax/adjustPriceActivity",
                data: {activityId: activityId},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    var prijsOmhoog = false;

                    if ($('#activity' + object.id).prop('checked')) {
                        prijsOmhoog = true;
                    }

                    var newPrijs = parseInt(object.prijs);
                    if (prijsOmhoog) {
                        prijs = prijs + newPrijs;
                    } else {
                        prijs = prijs - newPrijs;

                    }
                    $(".prijsTotaal").html(prijs);
                    $("input[name='prijsTotaal']").val(prijs);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function () {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,nextF today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultDate: '2015-02-12',
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            events: [
<?php foreach ($conferentieDagen as $conferentieDag) { ?>
                    {
                        id: '<?php echo $conferentieDag->id; ?>',
                        title: '<?php echo $conferentieDagen[0]->conferentie->naam; ?>',
                        start: '<?php echo $conferentieDag->datum; ?>'
                    },
<?php } ?>
            ]
        });

    });

</script>
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
    }

</style>
<!--<div id='calendar'></div>-->