
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Downloads</h3>
                    <span>All downloads of the conference <b><?php echo $conference->naam; ?></b></span>
                </div>  
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><?php echo anchor('download/add', '<span class="fa fa-plus"></span>'); ?></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">                                      
                <?php if (!empty($downloads)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Titel</th>
                                    <th>Upload</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($downloads as $download) { ?>
                                    <tr>
                                        <td><?php echo $download->titel; ?></td>
                                        <td><a href="<?php echo base_url(); ?>upload/files/<?php echo $download->upload; ?>" target="_blank"><?php echo $download->upload; ?></a></td>
                                        <td class="actioncol"><?php echo anchor('download/modify/' . $download->id, 'Modify'); ?></td>
                                        <td class="actioncol"><?php echo anchor('download/delete/' . $download->id, 'Delete', array('onclick' => 'return myFunction();')); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p> No downloadable files found for this conference. </p>
                <?php } ?>
            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>
<script>
    function myFunction() {
        var r = confirm("Are you sure you want to delete this download?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->
