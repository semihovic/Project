
    <div class="row">
        <div class="col-md-16">

            <!-- START MODIFY BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Modify Hotel</h3>
                        <span>Modify an existing hotel for this conference.</span>
                    </div>                                     
                </div>
                <div class="panel-body">                                    
                    <div class="row stacked">
                        <div class="col-md-16">   
                            <?php echo form_open('hotel/confirmModify');?>
                            <?php echo form_hidden('id',$hotel->id);
                            echo form_hidden('locationId', $hotel->locatieId); ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Name','name');?>
                                        <?php echo form_input(array('name' => 'name', 'required' => 'required', 'class' => 'form-control', 'value' => $hotel->naam));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Website','website');?>
                                        <?php echo form_input(array('name' => 'website', 'required' => 'required', 'type' => 'url', 'class' => 'form-control', 'value' => $hotel->website));?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Address','address');?>
                                        <?php echo form_input(array('name' => 'address', 'required' => 'required', 'class' => 'form-control', 'value' => $hotel->adres));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('Telephone nr.','tel');?>
                                        <?php echo form_input(array('name' => 'tel', 'required' => 'required', 'class' => 'form-control', 'value' => $hotel->telefoon));?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <?php echo form_label('City','city');?>
                                        <?php echo form_input(array('name' => 'city', 'required' => 'required', 'class' => 'form-control', 'value' => $hotel->plaats));?>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <?php echo form_label('Conference Location','location');?>
                                    <?php echo form_input(array('name' => 'location', 'class' => 'form-control', 'value' => $hotel->locatie->naam . ', ' . $hotel->locatie->land->naam, 'readonly' => 'true'));?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9">
                                    <?php echo form_submit(array('name' => 'submit', 'value' => 'Modify', 'class' => 'btn btn-warning btn-lg'));?>
                                    <?php echo anchor('manage/hotels', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg'));?>
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
