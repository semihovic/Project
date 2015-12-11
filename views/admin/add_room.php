
    <div class="row">
        <div class="col-md-16">

            <!-- START MODIFY BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Add Room</h3>
                        <span>Add a new room for this conference.</span>
                    </div>                                     
                </div>
                <div class="panel-body">                                    
                    <div class="row stacked">
                        <div class="col-md-16">        
                            <?php echo form_open('room/confirmAdd'); echo form_hidden('locationId', $conference->locatieId);?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Name','name');?>
                                        <?php echo form_input(array('name' => 'name', 'value' => "", 'required' => 'required', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo form_submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn btn-warning btn-lg'));?>
                                    <?php echo anchor('manage/rooms', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg'));?>
                                </div>
                            </div>
                            <?php echo form_close();?>
                        </div>
                    </div>                                    
                </div>
            </div>
            <!-- END MODIFY BLOCK -->

        </div>
    </div>
    

</div>
<!-- END PAGE CONTENT WRAPPER -->
