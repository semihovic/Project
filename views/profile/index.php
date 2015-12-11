
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>
        <!-- Foutcontrole Change Password -->
<script>

    $(document).ready(function () {
        $('form#changePasswordForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>/ajax/changePassword",
                data: {repeatNewPassword: $('#newPasswordRepeat').val(), newPassword: $('#newPassword').val(), password: $('#passwordCurrent').val()},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    $(".errorChangePassword").css('color', 'red');
                    $(".errorChangePassword").css('font-size', '20px');
                    $(".errorChangePassword").css('font-weight', 'bold');
                    $(".errorChangePassword").css('padding-top', '15px');
                    if (object.message === "wrong") {
                        $(".errorChangePassword").html("Invalid current password");
                    } else if (object.message === true) {
                        $(".errorChangePassword").css('color', 'green');
                        $(".errorChangePassword").html("Password succesfully changed");
                    } else {
                        $(".errorChangePassword").html("Passwords don't match.");
                    }

                }
            });
        });

        $("#editProfileForm").submit(function (e) {
            e.preventDefault();
            var dataString = $("#editProfileForm:eq(0)").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url(); ?>/ajax/changeProfile",
                async: false,
                data: dataString,
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    if (object.message === true) {
                        window.location.href = "<?php echo site_url();?>/profile/index";
                    } else {
                        alert("There was an error changing your profile. Username may already exist");
                    }
                }
            });
        });
        
        $("#editEmailForm").submit(function (e) {
            e.preventDefault();
            var dataString = $("#editEmailForm:eq(0)").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url();?>/ajax/changeEmail",
                async: false,
                data: dataString,
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    if (object.message === true) {
                        alert("You will be logged out and redirected to the homepage. Activate your new mail adress.");
                        window.location.href = "<?php echo site_url();?>/profile/index";
                    } else if (object.message === "password") {
                        alert("Invalid password. Please enter the correct password.");
                    } else {
                        alert("Invalid emails. Please match the two mail adresses.");
                    }
                }
            });
        });

    });

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }
</script>
<!-- Einde Foutcontrole Change Profile -->

<!-- Begin My Profile -->
<h1>My Profile</h1>
<div class="panel panel-default tabs">
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#editprofile" data-toggle="tab">Edit Profile</a></li>
        <li><a href="#changepassword" data-toggle="tab">Change Password</a></li>
        <li><a href="#attconference" data-toggle="tab">Attending Conferences</a></li>
        <li><a href="#pendingpayment" data-toggle="tab">Pending Payments</a></li>
    </ul>
    <div class="panel-body tab-content">
        <!-- Einde Change profile -->
        <div class="tab-pane active" id="editprofile">
            <?php echo form_open('profile/editConfirm', array('name' => 'editProfile', 'id' => 'editProfileForm')); ?>
            <div class="row">
                <div class="sixteen columns">
                    <p id="formtitle">Basic Information</p>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td><?php echo form_label('Title:', 'naam'); ?></td>
                                <td>
                                    <?php
                                    foreach ($aanspreking as $rb) {
                                        $aansprekingDropDown[$rb->id] = $rb->naam;
                                    }
                                    ?>
                                    <?php echo form_dropdown('aanspreking', $aansprekingDropDown, $user->aansprekingId, 'required class="form-control"'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('First name:', 'naam'); ?></td>
                                <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->voornaam)); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Last name:', 'achternaam'); ?></td>
                                <td><?php echo form_input(array('name' => 'achternaam', 'id' => 'achternaam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->achternaam)); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Username:', 'usernaam'); ?></td>
                                <td><?php echo form_input(array('name' => 'usernaam', 'id' => 'usernaam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->usernaam)); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Address:', 'adres'); ?></td>
                                <td><?php echo form_input(array('name' => 'adres', 'id' => 'adres', 'class' => 'form-control', 'required' => 'required', 'value' => $user->adres)); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Place:', 'woonplaats'); ?></td>
                                <td><?php echo form_input(array('name' => 'woonplaats', 'id' => 'woonplaats', 'required' => 'required', 'class' => 'form-control', 'value' => $user->woonplaats)); ?></td>
                            </tr>
                            <tr>
                                <?php
                                foreach ($landen as $dd) {
                                    $landenDropDown[$dd->id] = $dd->naam;
                                }
                                ?>
                                <td><?php echo form_label('Country:', 'naam'); ?></td>
                                <td><?php echo form_dropdown('land', $landenDropDown, $user->landId, 'required class="form-control"'); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><?php echo form_submit(array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            


            <?php echo form_open('profile/changeEmail', array('name' => 'editProfile', 'id' => 'editEmailForm')); ?>
            <div class="row">
                <div class="sixteen columns">
                    <p id="formtitle">Change Email address</p>
                    <p> You will have to re-activate your account by verifying your new mail address. </p>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td><?php echo form_label('Email:', 'email'); ?></td>
                                <td><?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'required' => 'required', 'type' => 'email')); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Repeat email:', 'emailConfirm'); ?></td>
                                <td><?php echo form_input(array('name' => 'emailConfirm', 'id' => 'emailConfirm', 'class' => 'form-control', 'required' => 'required', 'type' => 'email')); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Password:', 'paswoord'); ?></td>
                                <td><?php echo form_password(array('name' => 'paswoord', 'id' => 'paswoord', 'class' => 'form-control', 'required' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php echo form_submit(array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary')); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <!-- Einde Change profile -->
        <!-- Change password -->
        <div class="tab-pane" id="changepassword">
            <?php echo form_open('profile/changePasswordConfirm', array('name' => 'editProfile', 'id' => 'changePasswordForm')); ?>
            <div class="row">
                <div class="col-md-12">
                    <p id="formtitle">Change Password</p>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <tr>
                                <td><?php echo form_label('Current password:', 'password'); ?></td>
                                <td><?php echo form_password(array('name' => 'passwordCurrent', 'id' => 'passwordCurrent', 'class' => 'form-control', 'required' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('New password:', 'newPassword'); ?></td>
                                <td><?php echo form_password(array('name' => 'newPassword', 'id' => 'newPassword', 'class' => 'form-control', 'required' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td><?php echo form_label('Repeat new password:', 'newPasswordRepeat'); ?></td>
                                <td><?php echo form_password(array('name' => 'newPasswordRepeat', 'id' => 'newPasswordRepeat', 'class' => 'form-control', 'required' => 'required')); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php echo form_submit(array('name' => 'submitChangePassword', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary')); ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6"><div class="errorChangePassword"></div></div>
                <div class="col-md-3"></div>
            </div>

        </div>
        <!-- Einde Change password -->
        <!-- Attending conferences -->
        <div class="tab-pane" id="attconference">
            <p>You are registered for the following conferences and days</p>
            <table class="table table-striped">
                <tr>
                    <th>Conference</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Country</th>
                </tr>
            <?php foreach ($datas as $data) { ?>
                <?php $explode = explode('-', $data->conferentieDag->datum);?>
                <tr>
                    <td><?php echo anchor("conference/schedule/" . $data->conferentieDag->conferentie->id ,$data->conferentieDag->conferentie->naam); ?></td>
                <td> <?php echo date('d F Y', mktime(0, 0, 0, $explode[1], $explode[2], $explode[0])); ?></td>
                <td> <?php echo $data->conferentieDag->conferentie->locatie->naam; ?></td>
                <td> <?php echo $data->conferentieDag->conferentie->locatie->land->naam; ?></td>
                </tr>
            <?php } ?>
            </table>
        </div>
        <!-- Einde attending conferences -->
        <!-- Pending payments -->
        <div class="tab-pane" id="pendingpayment">
            <p>Below you can find all unpaid payments.</p>
                <p>You can deposit them on the following bank account:</p>
                <p><strong>Bank account</strong>: BE21 0444 4444 3444</p>
                <p>Make sure to include the statement(s) linked to the payments</p>
                <table class='table table-striped'>
                    <tr>
                    <th>Conference</th>
                    <th>Amount unpaid</th>
                    <th>Statement</th>
                    </tr>
            <?php foreach ($betalingen as $betaling) { ?>
                    <tr>
                    <td><?php echo anchor("conference/schedule/" . $betaling->conferentie->id ,$betaling->conferentie->naam); ?></td>
                    <td><?php echo $betaling->prijs;?> euro</td>
                    <td><?php echo $betaling->mededeling;?></td>
                </tr>
            <?php } ?>
                </table>
                
        </div>
        <!-- Einde pending payements -->
    </div>
</div>
<!-- Einde My Profile -->
