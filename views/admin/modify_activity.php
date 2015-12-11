
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Activities</h3>
                    <?php $datumExplode = explode('-', $conferenceDay->datum); ?>
                    <span>Activity for the conference <b><?php echo $conference->naam; ?></b> on day <b><?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?></b></span>
                </div>  
            </div>
            <div class="panel-body panel-body-table">     
                <div class="table-responsive">
                    <?php echo form_open("activity/modifyConfirm", array("id" => "formModifyActivity")); ?>

                    <table class="table table-bordered table-striped">
                        <?php
                        echo form_hidden('conferenceDayId', $conferenceDay->id);
                        if (empty($activity)) {
                            echo form_hidden('id', 0);
                        } else {
                            echo form_hidden('id', $activity->id);
                        }
                        ?>
                        <tr>
                            <th>Name</th>
                            <td>
                                <?php
                                if (!empty($activity)) {
                                    echo form_input(array("name" => "name", "value" => $activity->naam, "required" => "required"));
                                } else {
                                    echo form_input(array("name" => "name", "value" => "", "required" => "required"));
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Start time</th>
                            <td>
                                <?php
                                if (!empty($activity)) {
                                    echo form_input(array("name" => "starttime", "value" => $activity->beginuur, "required" => "required", "type" => "time", "id" => "starttime"));
                                } else {
                                    echo form_input(array("name" => "starttime", "value" => "", "required" => "required", "type" => "time", "id" => "starttime"));
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>End time</th>
                            <td>
                                <?php
                                if (!empty($activity)) {
                                    echo form_input(array("name" => "endtime", "value" => $activity->einduur, "required" => "required", "type" => "time", "id" => "endtime"));
                                } else {
                                    echo form_input(array("name" => "endtime", "value" => "", "required" => "required", "type" => "time", "id" => "endtime"));
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <td>
                                <?php
                                if (!empty($activity)) {
                                    echo form_input(array('name' => 'price', 'value' => $activity->prijs, 'required' => 'required', 'type' => 'number'));
                                } else {
                                    echo form_input(array('name' => 'price', 'required' => 'required', 'type' => 'number'));
                                    ?>
                                <?php } ?>
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
        $('#formModifyActivity').submit(function (e) {
            //start time
            var start_time = $("#starttime").val();
                
            //end time
            var end_time = $("#endtime").val();

            //convert both time into timestamp
            var stt = new Date("November 13, 2013 " + start_time);
            stt = stt.getTime();

            var endt = new Date("November 13, 2013 " + end_time);
            endt = endt.getTime();

            //by this you can see time stamp value in console via firebug

            if (stt > endt) {
                e.preventDefault();
                alert("The end time can not be earlier than the begin time.");
            }
        });
    });
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->


