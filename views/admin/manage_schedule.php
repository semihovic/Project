
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Schedule</h3>
                    <span>Schedule of the conference <?php echo $conference->naam; ?></span>
                </div>  
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="#" class="addDay"><span class="fa fa-plus"></span></a></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">     
                <?php if (!empty($conferenceDays)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th width="20%" colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($conferenceDays as $conferenceDay) { ?>
                                    <tr>
                                        <?php $datumExplode = explode('-', $conferenceDay->datum); ?>
                                        <td><?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?></td>
                                        <td class="actioncol"><?php echo anchor('schedule/overview/' . $conferenceDay->id, 'Overview'); ?></td>
                                        <td class="actioncol"><?php echo anchor('schedule/delete/' . $conferenceDay->id, 'Delete', array('onclick' => 'return myFunction();')); ?></td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <td><b>Days that still have sessions/activities can not be deleted.</b></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>

                <?php } else { ?>
                    <p class="addNewDay"> No days found to be scheduled. </p>
                <?php } ?>     

            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>

<script>
    $(document).ready(function () {
        var boolean = false;
        $(".addDay").click(function (e) {
            e.preventDefault();
            if (boolean != true) {
                 <?php if (!empty($conferenceDays)) { ?>
                $("tbody").prepend('<tr><td>Insert a day and press add (Format: dd/mm/yy)</td><td class="actioncol"><input type="date" value="" class="addDayText"/></td><td class="actioncol"><a href="#" class="addDayClick">Add</a></td></tr>');             
                 <?php } else { ?>
                $(".addNewDay").before('<div class="table-responsive"><table class="table table-bordered table-striped"><thead><tr><th>Date</th><th width="20%" colspan="2">Action</th></thead><tbody><tr><td>Insert a day and press add (Format: dd/mm/yy)</td><td class="actioncol"><input type="date" value="" class="addDayText"/></td><td class="actioncol"><a href="#" class="addDayClick">Add</a></td></tr></tbody></table></div>');
                $(".addNewDay").hide();
                  <?php } ?>
                makeclickevent();
                boolean = true;
            }
        });

        function makeclickevent() {
            $(".addDayClick").click(function () {
                var day = $(".addDayText").val();
                $.ajax({type: "POST",
                    url: "<?php echo site_url() ?>/schedule/addDay",
                    data: {day: day},
                    async: false,
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        if (object.gelukt === true) {
                            window.location.reload(true);
                        } else {
                            alert("This day already exists for the current conference. Cannot add.");
                        }
                    }
                });
                
            });
        }
    });

    function myFunction() {
        var r = confirm("Are you sure you want to delete this day?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->


