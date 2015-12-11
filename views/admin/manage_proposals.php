
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Proposals</h3>
                    <span>All proposals of <b><?php echo $conference->naam; ?></b></span>
                </div>                                     
            </div>
            <div class="panel-body panel-body-table">                                      
                <?php
                foreach ($statussen as $status) {
                    $dropDownStatus[$status->id] = $status->naam;
                }
                ?>
                <?php if (!empty($voorstellen)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Spreker</th>
                                    <th>Titel</th>
                                    <th>Beschrijving</th>
                                    <th>Upload</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($voorstellen as $voorstel) { ?>
                                    <tr>
                                        <td><?php echo $voorstel->deelnemer->voornaam; ?> <?php echo $voorstel->deelnemer->achternaam; ?></td>
                                        <td><?php echo $voorstel->titel; ?></td>
                                        <td><?php echo $voorstel->beschrijving; ?></td>
                                        <td><a href="<?php echo base_url(); ?>upload/files/<?php echo $voorstel->upload; ?>" target="_blank"><?php echo $voorstel->upload; ?></a></td>
                                        <td><?php echo form_dropdown('status', $dropDownStatus, $voorstel->status->id, 'class="dropDownStatus" data-id="' . $voorstel->id . '"'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p> No proposals found. </p>
                <?php } ?>
            </div>
        </div>
        <!-- END HOTELS BLOCK -->

    </div>
</div>


</div>

<script>
    $(document).ready(function () {
        $(".dropDownStatus").change(function () {
            $.ajax({type: "POST",
                url: "<?php echo site_url() ?>/proposal/edit",
                data: {statusId: $(this).val(), proposalId: $(this).data("id")},
                success: function (result) {
                    var object = jQuery.parseJSON(result);
                    alert("Succesfully changed proposal\n" + "You changed from: " + object.titel + ".\n" + "You changed the status to: " + object.status.naam);
                }
            });
        });
    });
</script>

<!-- END PAGE CONTENT WRAPPER -->
