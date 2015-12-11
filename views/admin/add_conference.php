                    

<div class="row">
    <div class="col-md-16">

        <!-- START MODIFY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Add Conference</h3>
                    <span>Add a new conference.</span>
                </div>                                     
            </div>
            <div class="panel-body">                                    
                <div class="row stacked">
                    <div class="col-md-16">                                            
                        <?php
                        $statusdropdown[""] = "Select a status";
                        foreach ($statussen as $status) {
                            $statusdropdown[$status->id] = $status->naam;
                        }
                        echo form_open('conference/confirmAdd', array('id' => 'modifyConferenceForm'));
                        ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Name', 'name'); ?>
                                    <?php echo form_input(array('name' => 'name', 'required' => 'required', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <?php
                            $landenDropDown[""] = "Select a Country";
                            foreach ($landen as $land) {
                                $landenDropDown[$land->id] = $land->naam;
                            }
                            ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Location Name', 'location');
                                    ?>
                                    <?php echo form_input(array('name' => 'location', 'required' => 'required', 'class' => 'form-control locationName', 'placeholder' => 'name, city')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Status', 'status'); ?></th>
                                    <?php echo form_dropdown('status', $statusdropdown, '', 'required class="form-control"'); ?></td>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Location Country', 'locationCountry');?>
                                    <?php echo form_dropdown('country', $landenDropDown, '', 'required class="form-control"');?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Start Date', 'startdate'); ?>
                                    <?php echo form_input(array('name' => 'startdate', 'required' => 'required', 'type' => 'date', 'id' => 'startdate', 'class' => 'form-control')); ?>                                  
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('End Date', 'enddate'); ?>
                                    <?php echo form_input(array('name' => 'enddate', 'required' => 'required', 'type' => 'date', 'id' => 'enddate', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <?php echo form_label('Extra Info', 'info'); ?>
                                    <?php echo form_textarea(array('name' => 'info', 'required' => 'required', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="pull-right">
                                    <?php echo form_submit(array('name' => 'submit', 'value' => 'Add', 'class' => 'btn btn-warning btn-lg')); ?>
                                    <?php echo anchor('admin/index', 'Cancel', array('class' => 'cancel btn btn-warning btn-lg')); ?>
                                </div>
                            </div>
                        </div>

                        <?php echo form_close(); ?>

                    </div>
                </div>                                    
            </div>
        </div>
        <!-- END MODIFY BLOCK -->

    </div>
</div>

<script>
    $(document).ready(function () {

        $("form#modifyConferenceForm").submit(function (e) {
            var startdate = new Date($("#startdate").val());
            var enddate = new Date($("#enddate").val());

            if (startdate.setHours(0, 0, 0, 0) >= enddate.setHours(0, 0, 0, 0)) {
                e.preventDefault();
                alert("Start date has to be an earlier date than end date.");
            }
            
            if ($(".locationName").val().indexOf(",") === -1) {
                e.preventDefault();
                alert("Location\nYou have to specify a name and a city. Exploded by a ','.\n Example: 'Thomas More Kempen, Geel");
            }
        });
    });
</script>
</div>
<!-- END PAGE CONTENT WRAPPER -->
