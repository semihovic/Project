<!-- dit is voor de banner. Dit moet in de content want de banner moet niet op elke pagina worden weergegeven!
-->

<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />

<h1><?php echo $title; ?></h1>

<?php echo form_open('home/aanmelden', array('name' => 'myform', 'id' => 'loginForm')); ?>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <?php echo form_label('Email', 'email'); ?>
            <?php echo form_input(array('name' => 'email', 'id' => 'email', 'size' => '30','class' => 'form-control', 'required' => 'required', 'type' => 'email')); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo form_label('Wachtwoord', 'password'); ?>
        <?php echo form_password(array('name' => 'password', 'id' => 'password', 'size' => '30','class' => 'form-control', 'required' => 'required')); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <?php echo form_submit(array('name' => 'mysubmit', 'value' => 'Login','class' => 'btn btn-primary')); ?>
        <?php echo anchor('home', 'Cancel', array('class' => 'btn btn-primary'));?>
    </div>
</div>

<?php echo form_close(); ?>

<div class="row">
    <div class="col-md-12">
        <div class="error"></div>
    </div>
</div>

</br>
<p> <?php echo anchor('user/vergeten', 'Forgot your password?'); ?> </p>
</br>

<p>No account? <?php echo anchor('user/nieuw', 'Register'); ?> </p>
</br>
<script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>
<script>
    $(document).ready(function() {
        $(".password").keyup(function() {
            if (!(".error").html() === "") {
                $(".error").html("");
            }
        });
        
        $(".email").keyup(function() {
            if (!(".error").html() === "") {
                $(".error").html("");
            }
        });
        
        $("#loginForm").submit(function(e) {
            e.preventDefault();
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/home/aanmelden",
                data: {email: $("#email").val(), paswoord: $("#password").val()},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    if (object.success === "signin") {
                        window.location.href = "<?php echo site_url() . '/conference/signin'?>";
                    } else if (object.success === true) {
                        window.location.href = "<?php echo site_url() . '/home/index'?>";
                    } else {
                        $(".error").css('color', 'red');
                        $(".error").css('font-size', '20px');
                        $(".error").css('font-weight', 'bold');
                        $(".error").css('padding-top', '15px');
                        $(".error").html("Invalid username/password. Please write in correct information.");
                    }
                }
            });
        });
    });
</script>