
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Profiles</h3>
                    <span>All registered users</span>
                </div>                                     
            </div>
            <div class="panel-body panel-body-table">                                      
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Naam</th>
                                <th>Adres</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($levels as $level) {
                                $levelDropDown[$level->id] = $level->naam;
                            } ?>
                            <?php foreach ($users as $us) { ?>
                                <tr>
                                    <td><?php echo $us->voornaam; ?> <?php echo $us->achternaam; ?></td>
                                    <td><?php echo $us->adres; ?></td>
                                    <td><?php echo $us->usernaam; ?></td>
                                    <td><?php echo $us->email; ?></td>
                                    <td class="actioncol"><?php echo form_dropdown('level', $levelDropDown, $us->niveau->id, 'class="changeLevel" data-id="' . $us->id . '"');?></td>
                                    <td class="actioncol"><?php if ($us->locked == 0) { echo anchor('profile/lock/' . $us->id, 'Lock', array('onclick' => 'return myFunction;')); } else { echo anchor('profile/unlock/' . $us->id, 'Unlock', array('onclick' => 'return myFunction2();'));} ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>


</div>


<script>
    $(document).ready(function () {
        $(".changeLevel").change(function () {
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/profile/changeLevel",
                data: {levelId: $(this).val(), userId: $(this).data("id")},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    if (object.success === true) {
                        alert("Succesfully changed role.");
                    } else {
                        alert("There was an error changing the role. Please try again.");
                    }
                }
            });
        });
    });
    function myFunction() {
        var r = confirm("Are you sure you want to lock this profile?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
    
    function myFunction() {
        var r = confirm("Are you sure you want to unlock this profile?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>


<!-- END PAGE CONTENT WRAPPER -->
