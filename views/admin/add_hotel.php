
    <div class="row">
        <div class="col-md-16">

            <!-- START ADD BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Add Hotel</h3>
                        <span>Add a new hotel for this conference.</span>
                    </div>                                     
                </div>
                <div class="panel-body">                                    
                    <div class="row stacked">
                        <div class="col-md-16"> 
                            <?php echo form_open('hotel/confirmAdd');?>
                            <?php echo form_hidden('locationId', $conference->locatieId);?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Name','name');?>
                                        <?php echo form_input(array('name' => 'name', 'required' => 'required', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Website','website');?>
                                        <?php echo form_input(array('name' => 'website', 'required' => 'required', 'type' => 'url', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Address','address');?>
                                        <?php echo form_input(array('name' => 'address', 'required' => 'required', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Telephone nr.','tel');?>
                                        <?php echo form_input(array('name' => 'tel', 'required' => 'required', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('City','city');?>
                                        <?php echo form_input(array('name' => 'city', 'required' => 'required', 'class' => 'form-control'));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <?php echo form_label('Conference Location','location');?>
                                    <?php echo form_input(array('name' => 'location', 'value' => $conference->locatie->naam . ', ' . $conference->locatie->land->naam, 'class' => 'form-control', 'readonly' => 'true'));?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo form_submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn btn-warning btn-lg'));?>
                                    <?php echo anchor('manage/hotels', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg'));?>
                                </div>
                            </div>
                        </div>
                    </div>                                    
                </div>
            </div>
            <!-- END ADD BLOCK -->

        </div>
    </div>
    

</div>
<!-- END PAGE CONTENT WRAPPER -->
