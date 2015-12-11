
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>
<h1> My subjects </h1>
<?php if (!empty($voorstellen)) { ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Title </th>
                    <th> Summary </th>
                    <th> Conference </th>
                    <th> Uploaded File </th>
                    <th> Status </th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($voorstellen as $voorstel) { ?>
                    <tr>
                        <td> <?php echo $voorstel->titel ?> </td>
                        <td> <?php echo $voorstel->beschrijving ?>  </td>
                        <td> <?php echo $voorstel->conferentie->naam ?>  </td>
                        <td><a href="<?php echo base_url(); ?>upload/files/<?php echo $voorstel->upload; ?>" target="_blank"><?php echo $voorstel->upload; ?></a></td>
                        <td> <?php echo $voorstel->status->naam ?>  </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <p> No subjects found. Please propose one. </p>
<?php } ?>
<p><?php echo anchor('speaker/proposeSubject', 'Create New Subject', array('class' => 'btn btn-primary')); ?> <?php echo anchor('home/index', 'Home', array('id' => 'button', 'class' => 'btn btn-primary')); ?>  </p>

