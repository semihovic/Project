
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>    <?php echo form_open_multipart('speaker/writeSubject'); ?>
        <h1> Submit a new subject </h1>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Title', 'title');?>
                    <?php echo form_input(array('name' => 'title', 'id' => 'titel', 'placeholder' => 'Titel', 'required' => 'required', 'class' => 'form-control')); ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Summary', 'summary');?>
                    <?php echo form_textarea(array('name' => 'summary', 'id' => 'samenvatting', 'placeholder' => 'Samenvatting', 'required' => 'required', 'class' => 'form-control')); ?>               
                </div>
            </div>
        </div>
        <?php $conferenceDropDown[""] = "Select a conference";?>
        <?php foreach($conferenties as $conferentie) { 
            $conferenceDropDown[$conferentie->id] = $conferentie->naam;
            } ?>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Conference', 'conferenceId');?>
                    <?php echo form_dropdown('conferenceId', $conferenceDropDown, '', 'class="form-control" required');?>            
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Presentation(pdf/ppt)', 'userfile');?>
                    <?php echo form_upload(array('name' => 'userfile', 'id' => 'userfile', 'class' => 'form-control')); ?> 
                    <?php if (isset($error)) { echo $error; } ?>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                 <?php echo form_submit(array('name' => 'submitProposeSubject', 'value' => 'Submit', 'id' => 'idSubmit', 'class' => 'btn btn-primary')); ?> <?php if ($user->niveauId != 3 ) { echo anchor('home/sprekerverzoek', 'Cancel', array('id' => 'button', 'class' => 'btn btn-primary')); } else { echo anchor('home/index', 'Cancel', array('id' => 'button', 'class' => 'btn btn-primary')); } ?>
            </div>
        </div>
        <?php echo form_close(); ?>
        
    </body>
</html>
