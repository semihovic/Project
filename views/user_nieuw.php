<!-- dit is voor de banner. Dit moet in de content want de banner moet niet op elke pagina worden weergegeven!
-->

        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . APPPATH; ?>css/frontend/banner.css" media="screen" />
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/jssor.slider.mini.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . APPPATH; ?>js/frontend/banner.js"></script>

<script>
    canForward = true;

    $(document).ready(function () {
        $('#paswoord2').keyup(function () {
            if ($('#paswoord2').val() == "") {
                $("td.paswoord2Error").html('');
            } else if ($('#paswoord').val() != $('#paswoord2').val()) {
                $("td.paswoord2Error").css('color', 'red');
                $("td.paswoord2Error").html('Passwords do not match');
            } else {
                $("td.paswoord2Error").css('color', 'green');
                $("td.paswoord2Error").html('Valid');
            }
        });

        $('#usernaam').keyup(function () {
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/ajax/checkUsername",
                data: {username: $('#usernaam').val()},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    if ($('#usernaam').val() == "") {
                        $("td.usernameError").html('');
                        $("td.usernameError").css('color', 'black');
                    } else if (object.bool == true) {
                        $("td.usernameError").css('color', 'red');
                        $("td.usernameError").html('Not available');
                    } else {
                        $("td.usernameError").css('color', 'green');
                        $("td.usernameError").html('Available');
                    }
                }
            });
        });

        $('#email').keyup(function () {
            if (!isValidEmailAddress($(this).val())) {
                if ($('#email').val() == "") {
                    $("td.emailError").html('');
                    $("td.emailError").css('color', 'black');
                } else {
                    $("td.emailError").css('color', 'red');
                    $("td.emailError").html('Not Valid');
                }
            } else {
                $.ajax({type: "POST",
                    url: "<?php echo site_url() ?>/ajax/checkEmail",
                    data: {email: $('#email').val()},
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        if ($('#email').val() == "") {
                            $("td.emailError").html('');
                            $("td.emailError").css('color', 'black');
                        } else if (object.bool == true) {
                            $("td.emailError").css('color', 'red');
                            $("td.emailError").html('Not available');
                        } else {
                            $("td.emailError").css('color', 'green');
                            $("td.emailError").html('Available');
                        }
                    }
                });
            }

        });

        $('#naam').keyup(function () {
            if ($("td.naamError").html() == 'Required field') {
                $("td.naamError").html('');
            }
        });
        $('#achternaam').keyup(function () {
            if ($("td.achternaamError").html() == 'Required field') {
                $("td.achternaamError").html('');
            }
        });
        $('#adres').keyup(function () {
            if ($("td.adresError").html() == 'Required field') {
                $("td.adresError").html('');
            }
        });
        $('#woonplaats').keyup(function () {
            if ($("td.paswoordError").html() == 'Required field') {
                $("td.paswoordError").html('');
            }
        });
        $('#paswoord').keyup(function () {
            if ($("td.woonplaatsError").html() == 'Required field') {
                $("td.woonplaatsError").html('');
            }
        });

        $('form#formRegister').submit(function (e) {
            if (!(formCheck())) {
                e.preventDefault();
            }
        });
    });

    function formCheck() {
        canForward = true;

        if ($('#paswoord2').val() !== $('#paswoord').val()) {
            canForward = false;
            $("td.paswoord2Error").css('color', 'red');
            $("td.paswoord2Error").html('Passwords do not match');
        } else {
            $("td.paswoord2Error").css('color', 'black');
            $("td.paswoord2Error").html('');
        }

        if ($("#naam").val() == "") {
            canForward = false;
            $("td.naamError").css('color', 'red');
            $("td.naamError").html('Required field');
        } else {
            $("td.naamError").css('color', 'black');
            $("td.naamError").html('');
        }

        if ($('#achternaam').val() == "") {
            canForward = false;
            $("td.achternaamError").css('color', 'red');
            $("td.achternaamError").html('Required field');
        } else {
            $("td.achternaamError").css('color', 'black');
            $("td.achternaamError").html('');
        }

        if ($('#usernaam').val() == "") {
            canForward = false;
            $("td.usernameError").css('color', 'red');
            $("td.usernameError").html('Required Field');
        } else {
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/ajax/checkUsername",
                data: {username: $('#usernaam').val()},
                success: function (result) {
                    var succes = jQuery.parseJSON(result);
                    if (succes !== true) {
                        canForward = false;
                        $("td.usernameError").css('color', 'red');
                        $("td.usernameError").html('Not available - Take a different username');
                    } else {
                        $("td.usernameError").css('color', 'black');
                        $("td.usernameError").html('');
                    }
                }
            });
        }

        if ($('#adres').val() == "") {
            canForward = false;
            $("td.adresError").css('color', 'red');
            $("td.adresError").html('Required field');
        } else {
            $("td.adresError").css('color', 'black');
            $("td.adresError").html('');
        }

        if ($('#woonplaats').val() == "") {
            canForward = false;
            $("td.woonplaatsError").css('color', 'red');
            $("td.woonplaatsError").html('Required field');
        } else {
            $("td.woonplaatsError").css('color', 'black');
            $("td.woonplaatsError").html('');
        }

        if ($('#email').val() == "") {
            canForward = false;
            $("td.emailError").css('color', 'red');
            $("td.emailError").html('Required field');
        } else {
            if (isValidEmailAddress($('#email').val())) {
                $.ajax({type: "POST",
                    url: "<?php echo site_url() ?>/ajax/checkEmail",
                    data: {email: $('#email').val()},
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        if (object.bool == true) {
                            canForward = false;
                            $("td.emailError").css('color', 'red');
                            $("td.emailError").html('Not available');
                        } else {
                            $("td.emailError").css('color', 'black');
                            $("td.emailError").html('');
                        }
                    }
                });
            } else {
                canForward = false;
                $("td.emailError").css('color', 'red');
                $("td.emailError").html('Not a valid e-mail address');
            }

        }

        if ($('#paswoord').val() == "") {
            canForward = false;
            $("td.paswoordError").css('color', 'red');
            $("td.paswoordError").html('Required field');
        } else {
            $("td.paswoordError").css('color', 'black');
            $("td.paswoordError").html('');
        }

        if ($('#paswoord2').val() == "") {
            canForward = false;
            $("td.paswoord2Error").css('color', 'red');
            $("td.paswoord2Error").html('Required field');
        }

        return canForward;
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }
</script>

<?php
$attributes = array('name' => 'myform', 'id' => 'formRegister', 'class' => 'form-horizontal');
echo form_open('user/registreer', $attributes);
?>
<div class="row">
    
        <p id="formtitle"><?php echo $title; ?></p>
        <p> Please fill in the fields and click on submit. All information is confidentially and will <strong>never</strong> be given away.</p>
    <div class="col-md-6">
        <table class="table">
            <tr>
                <td><?php echo form_label('Title:', 'aanspreking'); ?></td>
                <td>
                    <?php
                    $select[""] = "Select a salutation";
                    foreach ($aanspreking as $rb) {
                        $select[$rb->id] = $rb->naam;
                    }
                    ?>
                    <?php echo form_dropdown('aanspreking', $select, '', 'id="aanspreking" class="form-control select" required'); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo form_label('First name:', 'naam'); ?></td>
                <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="naamError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Last name:', 'achternaam'); ?></td>
                <td><?php echo form_input(array('name' => 'achternaam', 'id' => 'achternaam', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="achternaamError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Username:', 'username'); ?></td>
                <td><?php echo form_input(array('name' => 'usernaam', 'id' => 'usernaam', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="usernameError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Address:', 'adres'); ?></td>
                <td><?php echo form_input(array('name' => 'adres', 'id' => 'adres', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="achternaamError"></td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table">
            <tr>
                <td><?php echo form_label('Place:', 'woonplaats'); ?></td>
                <td><?php echo form_input(array('name' => 'woonplaats', 'id' => 'woonplaats', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="woonplaatsError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Country:', 'naam'); ?></td>
                <td>    
                    <?php
                    $selectLanden[""] = "Select A Country";
                    foreach ($landen as $dd) {
                        $selectLanden[$dd->id] = $dd->naam;
                    }
                    ?>
                    <?php echo form_dropdown('land', $selectLanden, 23, 'id="land" class="form-control select" required'); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo form_label('Email:', 'email'); ?></td>
                <td><?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'type' => 'email', 'required' => 'required')); ?></td>
                <td class="emailError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Password:', 'paswoord'); ?></td>
                <td><?php
                    $data = array('name' => 'paswoord', 'id' => 'paswoord', 'class' => 'form-control', 'required' => 'required');
                    echo form_password($data);
                    ?>
                </td>
                <td class="paswoordError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Repeat password:', 'paswoord2'); ?></td>
                <td><?php
                    $data2 = array('name' => 'paswoord2', 'id' => 'paswoord2', 'class' => 'form-control', 'required' => 'required');
                    echo form_password($data2);
                    ?>
                </td>
                <td class="paswoord2Error"></td>
            </tr>
            <tr>
                <td></td>
                <td><?php
                    $data = array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary');
                    echo form_submit($data);
                    echo " ";
                    ?>
                 <?php
                    $data = array('name' => 'mysubmit', 'value' => "Back", 'content' => "Back", 'size' => '30', 'class' => 'btn btn-primary');
                    echo anchor("home/login",form_button($data));
                    ?>
                </td>
                
            </tr>
        </table>
        <?php echo form_close();?>
    </div>
</div>