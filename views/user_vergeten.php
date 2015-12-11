<!-- dit is voor de banner. Dit moet in de content want de banner moet niet op elke pagina worden weergegeven!
-->

<link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>

<h4><?php echo $title; ?></h4>

<?php
$attributes = array('name' => 'myform');
echo form_open('user/nieuwwachtwoord', $attributes);
?>
<p>Please write your email: </p>
<table>

    <tr>
        <td><?php echo form_label('Email:', 'email'); ?></td>
        <td> <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30', "class" => "form-control")); ?></td>
    </tr>
    <tr>
        <td></td>
        <td><?php $data = array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary');
              echo form_submit($data) . " ";
            ?>
            <?php
            $data = array('name' => 'mysubmit', 'value' => "Back", 'content' => "Back", 'size' => '30', 'class' => 'btn btn-primary');
            echo anchor("home/login", form_button($data));
            ?>
        </td>
    </tr>
</table>