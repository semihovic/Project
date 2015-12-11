
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Download</h3>
                    <?php if (isset($download)) { ?>
                        <span>Add Download </span>
                    <?php } else { ?>
                        <span>Modify Download </span>
                    <?php } ?>
                </div>  
            </div>
            <div class="panel-body">    
                <div class="row stacked">
                    <div class="col-md-16">  
                        <?php echo form_open_multipart("download/modifyConfirm"); ?>
                        <?php
                        if (empty($download)) {
                            echo form_hidden('id', 0);
                        } else {
                            echo form_hidden('id', $download->id);
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Title', 'title'); ?>
                                    <?php
                                    if (!empty($download)) {
                                        echo form_input(array("value" => $download->titel, "name" => "title", "required" => "required", "class" => "form-control"));
                                    } else {
                                        echo form_input(array("name" => "title", "required" => "required", "class" => "form-control"));
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($download)) { ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Old document', 'olddocument'); ?>
                                        <a href="<?php echo base_url(); ?>upload/files/<?php echo $download->upload; ?>" target="_blank" class="form-control"><?php echo $download->upload; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('New Document', 'userfile'); ?>
                                    <?php
                                    if (!empty($download)) {
                                        echo form_upload(array("name" => "userfile", "id" => "userfile", "class" => "form-control", "onchange" => "callme(this)"));
                                    } else {
                                        echo form_upload(array("name" => "userfile", "id" => "userfile", "required" => "required", "class" => "form-control", "onchange" => "callme(this)"));
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" id="hiddenFileName" name="hiddenFileName"/>
                        <div class="row">
                            <div class="col-md-9">
                                <?php echo form_submit(array('name' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-warning btn-lg')); ?>
                                <?php echo anchor('manage/downloads', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg')); ?>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>    
            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>

<script>
    function callme(file) {
        var filename = file.value.replace(/^.*[\\\/]/, '');
        $('#hiddenFileName').val(filename);
    }
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


