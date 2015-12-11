
<div class="row">
    <div class="col-md-16">

        <!-- START MODIFY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Edit Announcement</h3>
                </div>                                     
            </div>
            <div class="panel-body">                                    
                <div class="row stacked">
                    <div class="col-md-16">  
                        <?php echo form_open('announcement/modifyConfirm'); ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Titel', 'name');?>
                                    <?php if (empty($announcement)) {
                                        echo form_hidden('id', '0');
                                        echo form_input(array('name' => 'titel', 'class' => 'form-control', 'required' => 'required'));
                                    } else {
                                        echo form_hidden('id', $announcement->id);
                                        echo form_input(array('name' => 'titel', 'value' => $announcement->titel, 'class' => 'form-control', 'required' => 'required'));
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Omschrijving', 'omschrijving');?>
                                    <?php if (empty($announcement)) {
                                        echo form_textarea(array('name' => 'omschrijving', 'required' => 'required', 'class' => 'form-control', 'maxlength' => '255'));
                                    } else {
                                        echo form_textarea(array('name' => 'omschrijving', 'value' => $announcement->beschrijving, 'required' => 'required', 'class' => 'form-control', 'maxlength' => '255')); 
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <?php echo form_submit(array('name' => 'submit', 'value' => 'Modify', 'class' => 'btn btn-warning btn-lg'));?>
                                <?php echo anchor('manage/announcements', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg'));?>
                            </div>
                        </div>
                    </div>
                </div>                                    
            </div>
        </div>
        <!-- END MODIFY BLOCK -->

    </div>
</div>


</div>
<!-- END PAGE CONTENT WRAPPER -->
