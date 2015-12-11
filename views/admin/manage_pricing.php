
<div class="row">
    <div class="col-md-16">

        <!-- START HOTELS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Pricing</h3>
                    <span>Prices of the days in conference <b><?php echo $conference->naam; ?></b></span>
                </div>                                     
            </div>
            <div class="panel-body panel-body-table">                                       
                <?php if (!(empty($conferenceDays))) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">Date</th>
                                    <th width="20%">Price</th>
                                    <th width="10%">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($conferenceDays as $conferenceDay) { ?>
                                    <?php $datumExplode = explode('-', $conferenceDay->datum); ?>
                                    <tr>
                                        <td><?php echo date('d F Y (l)', mktime(0, 0, 0, $datumExplode[1], $datumExplode[2], $datumExplode[0])); ?></td>
                                        <td class="prijs<?php echo $conferenceDay->id; ?>"><?php echo $conferenceDay->prijs; ?></td>
                                        <td class="actioncol"><?php echo anchor('', "Modify", array("data-id" => $conferenceDay->id, "class" => "editPricing", "data-prijs" => $conferenceDay->prijs)); ?> </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <p> No days found. Please add extra days. </p>
                <?php } ?>                                  
            </div>
        </div>
        <!-- END HOTELS BLOCK -->
    </div>
</div>

<script>
    $(document).ready(function () {
        var id = 0;
        var prijs = 0;
        var oldNew = 0;
        var oldPrijs = 0;

        $(".editPricing").click(function (e) {
            e.preventDefault();
            if (oldNew !== id) {
                oldNew = id;
                oldPrijs = prijs;
                $(".prijs" + oldNew).html(oldPrijs);
            }
            id = $(this).data("id");
            prijs = $(this).data("prijs");

            $(".prijs" + id).html('<input type="number" value="' + prijs + '" class="prijsChange" data-id="' + id + '"/> Press enter to confirm the change!');
            maakkeypress();
        });
    });

    function maakkeypress() {
        $(".prijsChange").keydown(function (event) {
            if (event.keyCode === 13) {
                var prijsValue = $(".prijsChange").val();
                var id = $(this).data("id");
                $.ajax({type: "POST",
                    url: "<?php echo site_url() ?>/pricing/modify",
                    data: {conferentieDagId: id, prijs: prijsValue},
                    async: false,
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        $(".prijs" + object.id).html(object.prijs);
                        document.location.reload(true);
                    }
                });
            }
        });
    }
</script>

</div>
<!-- END PAGE CONTENT WRAPPER -->
