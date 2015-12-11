                 

<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Announcements</h3>
                    <span>All announcements of <?php echo $conference->naam; ?></span>
                </div>   
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><?php echo anchor('announcement/add', '<span class="fa fa-plus"></span>'); ?></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">                                              
                <?php if (!empty($announcements)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Titel</th>
                                    <th>Beschrijving</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($announcements as $a) { ?>
                                    <tr>
                                        <td><?php echo $a->titel; ?></td>
                                        <td><?php echo $a->beschrijving; ?></td>
                                        <td class="actioncol"><?php echo anchor('announcement/modify/' . $a->id, "Edit"); ?> </td>
                                        <td class="actioncol" colspan=""><?php echo anchor('announcement/delete/' . $a->id, "Delete", array('onclick' => 'return myFunction();')); ?> </td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <p> No announcements for this conference. </p>
                <?php } ?>
            </div>
        </div>                                    
        <!-- END HOTELS BLOCK -->
    </div>
</div>


</div>
<!-- END PAGE CONTENT WRAPPER -->

<script>
    function myFunction() {
        var r = confirm("Are you sure you want to delete this announcement?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
