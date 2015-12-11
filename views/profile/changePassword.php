<script>
    canForward = true;
    
    $(document).ready(function() {
        $('#newPasswordRepeat').keyup(function() {
            if ($('#newPasswordRepeat').val() == "") {
                $("td.paswoordRepeatError").html('');
            } else if ($('#newPassword').val() != $('#newPasswordRepeat').val()) {
                $("td.paswoordRepeatError").css('color', 'red');
                $("td.paswoordRepeatError").html('Passwords do not match');
            } else {
                $("td.paswoordRepeatError").css('color', 'green');
                $("td.paswoordRepeatError").html('Valid');
            }
        });
        
        $('#passwordCurrent').keyup(function() {
            $.ajax({type : "GET",
                url : "<?php echo site_url()?>/ajax/checkCurrentPassword",
                data : { password : $('#passwordCurrent').val() },
                success : function(result){
                    var object = jQuery.parseJSON(result);
                    if ($('#passwordCurrent').val() == "") {
                        $("td.currentPasswordError").html('');
                        $("td.currentPasswordError").css('color', 'black');
                    } else if (object.bool == false) {
                        $("td.currentPasswordError").css('color', 'red');
                        $("td.currentPasswordError").html('Incorrect password');
                    } else {
                        $("td.currentPasswordError").css('color', 'green');
                        $("td.currentPasswordError").html('Correct');
                    }
                }
            }); 
        });
        
        $('form#changePasswordForm').submit(function(e) {
            if (!(formPasswordCheck())) {
                e.preventDefault();
            }
        });
    });
    
    function formPasswordCheck() {
        canForward = true;
        //Controleren of huidig password gelijk is als hetgeen in de database
        if ($('#passwordCurrent').val() == "") {
            canForward = false;
            $("td.currentPasswordError").css('color', 'red');
            $("td.currentPasswordError").html('Required Field');
        } else {
            $.ajax({
                type : "GET",
                url : "<?php echo site_url()?>/ajax/checkCurrentPassword",
                data : { password : $('#passwordCurrent').val() },
                success : function(result){
                    var object = jQuery.parseJSON(result);
                    if (object.bool == false) {
                        $("td.currentPasswordError").css('color', 'red');
                        $("td.currentPasswordError").html('Incorrect password');
                        canForward = false;
                    } else {
                        $("td.currentPasswordError").css('color', 'green');
                        $("td.currentPasswordError").html('Correct');
                    }
                }
            });
        }
        
        //Controleren of twee x een juist nieuw wachtwoord is ingevuld
        if ($('#newPasswordRepeat').val() !== $('#newPassword').val()) {
            canForward = false;
            $("td.paswoordRepeatError").css('color', 'red');
            $("td.paswoordRepeatError").html('Passwords do not match');
        } else {
            $("td.paswoordRepeatError").css('color', 'black');
            $("td.paswoordRepeatError").html('');
        }
        
        return canForward;
    }
</script>
<?php echo form_open('profile/changePasswordConfirm', array('name' => 'editProfile', 'id' => 'changePasswordForm')); ?>
<div class="row"><div class="sixteen columns"><p id="formtitle">Edit Password</p>
        <table>
            <tr>
                <td><?php echo form_label('Current password:', 'password'); ?></td>
                <td><?php echo form_password(array('name' => 'passwordCurrent', 'id' => 'passwordCurrent', 'class' => 'form-control')); ?></td>
                <td class="currentPasswordError"></td>
            </tr>
            <tr>
                <td><?php echo form_label('New password:', 'newPassword'); ?></td>
                <td><?php echo form_password(array('name' => 'newPassword', 'id' => 'newPassword', 'class' => 'form-control')); ?></td>
            </tr>
            <tr>
               <td><?php echo form_label('New password Repeat:', 'newPasswordRepeat'); ?></td>
                <td><?php echo form_password(array('name' => 'newPasswordRepeat', 'id' => 'newPasswordRepeat', 'class' => 'form-control')); ?></td>
                <td class="paswoordRepeatError"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo form_submit(array('name' => 'submitChangePassword', 'value' => 'Submit', 'size' => '30','class' => 'btn btn-primary')); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php echo form_close(); ?>

