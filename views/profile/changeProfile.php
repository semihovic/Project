<script>
    canForward = true;
    
    $(document).ready(function() {

        $('#usernaam').keyup(function() {
            $.ajax({type : "GET",
                url : "<?php echo site_url()?>/ajax/checkUsername",
                data : { username : $('#usernaam').val() },
                success : function(result){
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
        
        $('#emailConfirm').keyup(function() {
            if (!isValidEmailAddress($(this).val())) {
                if ($('#emailConfirm').val() == "") {
                    $("td.emailConfirmError").html('');
                    $("td.emailConfirmError").css('color', 'black');
                } else {   
                    $("td.emailConfirmError").css('color', 'red');
                    $("td.emailConfirmError").html('Not Valid');
                }
            } else {
                $.ajax({type : "GET",
                    url : "<?php echo site_url()?>/ajax/checkEmail",
                    data : { email : $('#emailConfirm').val() },
                    success : function(result){
                        var object = jQuery.parseJSON(result);
                        if ($('#emailConfirm').val() == "") {
                            $("td.emailConfirmError").html('');
                            $("td.emailConfirmError").css('color', 'black');
                        } else if (object.bool == true) {
                            $("td.emailConfirmError").css('color', 'red');
                            $("td.emailConfirmError").html('Not available');
                        } else {
                            $("td.emailConfirmError").css('color', 'green');
                            $("td.emailConfirmError").html('Available');
                        }
                    }
                });
            }
        });
        
        $('#naam').keyup(function() {
            if ($("td.naamError").html() == 'Required field') {
                $("td.naamError").html('');
            }
        });
        $('#achternaam').keyup(function() {
            if ($("td.achternaamError").html() == 'Required field') {
                $("td.achternaamError").html('');
            }
        });
        $('#adres').keyup(function() {
            if ($("td.adresError").html() == 'Required field') {
                $("td.adresError").html('');
            }
        });
        $('#woonplaats').keyup(function() {
            if ($("td.paswoordError").html() == 'Required field') {
                $("td.passwordError").html('');
            }
        });

        $('form#editProfileForm').submit(function(e) {
            if (!(formEditProfileCheck())) {
                e.preventDefault();
            }
        });
        
        $('form#editEmailForm').submit(function(e) {
            if (!(formEditEmailCheck())) {
                e.preventDefault();
            }
        });
    });
    
    
    function formEditEmailCheck() {
        canForward = true;
        
        if (isValidEmailAddress($('#emailConfirm').val()) && isValidEmailAddress($('#email').val())) {
            if ($('#emailConfirm').val() !== $('#email').val()) {
                canForward = false;
                $("td.emailConfirmError").css('color', 'red');
                $("td.emailConfirmError").html('Emailadress does not match');
            }
        } 
        
        if ($('#emailConfirm').val() == "") {
            canForward = false;
            $("td.emailConfirmError").css('color', 'red');
            $("td.emailConfirmError").html('Required field');
        } else {
            if (isValidEmailAddress($('#emailConfirm').val())) {
                $.ajax({type : "GET",
                    url : "<?php echo site_url()?>/ajax/checkEmail",
                    data : { email : $('#email').val() },
                    success : function(result){
                        var object = jQuery.parseJSON(result);
                        if (object.bool == true) {
                            canForward = false;
                            $("td.emailConfirmError").css('color', 'red');
                            $("td.emailConfirmError").html('Not available');
                        } else {
                            $("td.emailConfirmError").css('color', 'black');
                            $("td.emailConfirmError").html('');
                        }
                    }
                });
            } else {
                canForward = false;
                $("td.emailConfirmError").css('color', 'red');
                $("td.emailConfirmError").html('Not a valid e-mail address');
            }
            
        }
        
        if ($('#email').val() == "") {
            canForward = false;
            $("td.emailError").css('color', 'red');
            $("td.emailError").html('Required field');
        } else {
            if (isValidEmailAddress($('#emailConfirm').val())) {
                $.ajax({type : "GET",
                    url : "<?php echo site_url()?>/ajax/checkEmail",
                    data : { email : $('#email').val() },
                    success : function(result){
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
        
        
        if ($('password').val() == "") {
            canForward = false;
            $("td.passwordError").css('color', 'red');
            $("td.passwordError").html('Required field');
        } else {
            $.ajax({type : "GET",
                    url : "<?php echo site_url()?>/ajax/checkCurrentPassword",
                    data : { password : $('password').val() },
                    success : function(result){
                        var object = jQuery.parseJSON(result);
                        if (object.bool == true) {
                            canForward = false;
                            $("td.passwordError").css('color', 'red');
                            $("td.passwordError").html('Incorrect password');
                        } else {
                            $("td.passwordError").css('color', 'black');
                            $("td.passwordError").html('');
                        }
                    }
                });
        }
        
        return canForward;
    }
    function formEditProfileCheck() {
        canForward = true;

        
        if ($( "#naam" ).val() == "") {
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
            $.ajax({type : "GET",
                url : "<?php echo site_url()?>/ajax/checkUsername",
                data : { username : $('#usernaam').val() },
                    success : function(result){
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

        return canForward;
    }
    
    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }
</script>

<?php
echo form_open('profile/editConfirm', array('name' => 'editProfile', 'id' => 'editProfileForm'));
?>
<div class="row"><div class="sixteen columns"><p id="formtitle"><?php echo $title; ?></p>
        <table>
            
            <tr>
                <td><?php echo form_label('Title:', 'naam'); ?></td>
                <td>
                    <select id="aanspreking" name="aanspreking" class="form-control">
                        <?php
                        foreach ($aanspreking as $rb) {
                            if ($user->aansprekingId != $rb['id']) {
                                echo "<option value='" . $rb['id'] . "'>" . $rb['id'] . "</option>";
                            } else {
                                echo "<option value='" . $rb['id'] . "' selected='selected'>" . $rb['naam'] . "</option>\n";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo form_label('First name:', 'naam'); ?></td>
                <td><?php echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->voornaam)); ?></td>
                <td class="naamError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Last name:', 'achternaam'); ?></td>
                <td><?php echo form_input(array('name' => 'achternaam', 'id' => 'achternaam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->achternaam)); ?></td>
                <td class="achternaamError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Username:', 'usernaam'); ?></td>
                <td><?php echo form_input(array('name' => 'usernaam', 'id' => 'usernaam', 'class' => 'form-control', 'required' => 'required', 'value' => $user->usernaam)); ?></td>
                <td class="usernameError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Address:', 'adres'); ?></td>
                <td><?php echo form_input(array('name' => 'adres', 'id' => 'adres', 'class' => 'form-control', 'required' => 'required', 'value' => $user->adres)); ?></td>
                <td class="achternaamError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Place:', 'woonplaats'); ?></td>
                <td><?php echo form_input(array('name' => 'woonplaats', 'id' => 'woonplaats', 'required' => 'required', 'class' => 'form-control', 'value' => $user->woonplaats)); ?></td>
                <td class="woonplaatsError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Country:', 'naam'); ?></td>
                <td>    
                    <select id="land" name="land" class="form-control">
                        <?php
                        foreach ($landen as $dd){
                            if ($user->landId != $dd['id']) {
                                echo "<option value='" . $dd['id'] . "'";
                                echo ">" . $dd['naam'] . "</option>";
                            } else {
                                echo "<option value='" . $dd['id'] . "'";
                                echo "selected='selected' >" . $dd['naam'] . "</option>\n";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php $data = array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30','class' => 'btn btn-primary');
                    echo form_submit($data); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php echo form_close(); ?>


<?php echo form_open('profile/changeEmail', array('name' => 'editProfile', 'id' => 'editEmailForm')); ?>
    <div class="row"><div class="sixteen columns"><p id="formtitle">Email aanpassen</p>
        <table>
            <tr>
                <td><?php echo form_label('Email:', 'email'); ?></td>
                <td><?php echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="emailError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Email:', 'emailConfirm'); ?></td>
                <td><?php echo form_input(array('name' => 'emailConfirm', 'id' => 'emailConfirm', 'class' => 'form-control', 'required' => 'required')); ?></td>
                <td class="emailConfirmError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('Password:', 'paswoord'); ?></td>
                <td><?php echo form_password(array('name' => 'paswoord', 'id' => 'paswoord', 'class' => 'form-control', 'required' => 'required'));?></td>
                <td class="passwordError"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo form_submit(array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30','class' => 'btn btn-primary')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php echo form_close(); ?>

