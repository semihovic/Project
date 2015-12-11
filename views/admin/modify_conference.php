
<div class="row">
    <div class="col-md-16">

        <!-- START MODIFY BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Modify Conference</h3>
                    <span>Modify info of this conference.</span>
                </div>                                     
            </div>
            <div class="panel-body">                                    
                <div class="row stacked">
                    <div class="col-md-16">    
                        <?php echo form_open('conference/confirmModify', array('id' => 'modifyConferenceForm')); ?>
                        <?php
                        foreach ($statussen as $status) {
                            $statusdropdown[$status->id] = $status->naam;
                        }
                        ?>
                        <div class="row">
                            <?php echo form_hidden('id', $conferentie->id); ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Name:', 'name'); ?>
                                    <?php echo form_input(array('name' => 'name', 'value' => $conferentie->naam, 'required' => 'required', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php
                                    $landenDropDown[""] = "Select a Country";
                                    foreach ($landen as $land) {
                                        $landenDropDown[$land->id] = $land->naam;
                                    }
                                    ?>
                                    <?php echo form_label('Location', 'location'); ?>
                                    <?php echo form_input(array('name' => 'location', 'value' => $conferentie->locatie->naam . ', ' . $conferentie->locatie->stad, 'required' => 'required', 'class' => 'form-control locationName', 'placeholder' => 'name, city')); ?>
                                    <?php echo form_hidden('locationId', $conferentie->locatieId); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Status:', 'status'); ?></th>
                                    <?php echo form_dropdown('status', $statusdropdown, $conferentie->statusConferentieId, 'required class="form-control"'); ?></td>
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Location Country', 'locationCountry');?>
                                    <?php echo form_dropdown('country', $landenDropDown, $conferentie->locatie->land->id, 'required class="form-control"');?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('Start Date:', 'startdate'); ?>
                                    <?php echo form_input(array('name' => 'startdate', 'value' => $conferentie->startdatum, 'required' => 'required', 'type' => 'date', 'id' => 'startdate', 'class' => 'form-control')); ?>                                  
                                </div>
                            </div>
                            <div class="col-md-3"></div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_label('End Date:', 'enddate'); ?>
                                    <?php echo form_input(array('name' => 'enddate', 'value' => $conferentie->einddatum, 'required' => 'required', 'type' => 'date', 'id' => 'enddate', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <?php echo form_label('Extra Info', 'info'); ?>
                                    <?php echo form_textarea(array('name' => 'info', 'value' => $conferentie->extraInfo, 'required' => 'required', 'class' => 'form-control')); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="pull-right">
                                    <?php echo form_submit(array('name' => 'submit', 'value' => 'Modify', 'class' => 'btn btn-warning btn-lg')); ?>
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
            //Controleren of enddatum na begindatum is
            if (startdate.setHours(0, 0, 0, 0) >= enddate.setHours(0, 0, 0, 0)) {
                e.preventDefault();
                alert("The start date can not be later than the end date.");
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
