<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var reedsGeklikt = false;
        $('.showArchieved').click(function (e) {
            e.preventDefault();
            if (reedsGeklikt != true) {
                $.ajax({
                    url: "<?php echo site_url() ?>/ajax/showArchived",
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        var string = '';
                        for (var i = 0; i < object.length; i++) {
                            string += '<tr>' +
                                    '<td><b>' + object[i].naam + '</b></td>' +
                                    '<td><span class="label label-success">' + object[i].startdatum.split('-').reverse().join("-") + '</span></td>' +
                                    '<td><span class="label label-danger">' + object[i].einddatum.split('-').reverse().join("-") + '</span></td>' +
                                    '<td>' + object[i].status.naam + '</td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/modify/' + object[i].id + '">Modify</a></td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/manage/' + object[i].id + '">Manage</a></td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/dearchive/' + object[i].id + '">Dearchive</a></td>' +
                                    '</tr>';
                        }
                        $('tbody').html(string);
                        $("span.eye-iconClick").removeClass("fa").removeClass("fa-eye").addClass("fa").addClass("fa-eye-slash");
                    }
                });
                reedsGeklikt = true;
            } else {
                reedsGeklikt = false;
                
                $.ajax({
                    url: "<?php echo site_url() ?>/ajax/showUnarchived",
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        var string = '';
                        for (var i = 0; i < object.length; i++) {
                            string += '<tr>' +
                                    '<td><b>' + object[i].naam + '</b></td>' +
                                    '<td><span class="label label-success">' + object[i].startdatum.split('-').reverse().join("-") + '</span></td>' +
                                    '<td><span class="label label-danger">' + object[i].einddatum.split('-').reverse().join("-") + '</span></td>' +
                                    '<td>' + object[i].status.naam + '</td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/modify/' + object[i].id + '">Modify</a></td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/manage/' + object[i].id + '">Manage</a></td>' +
                                    '<td class="actioncol">' + '<a href="<?php echo site_url(); ?>/conference/archive/' + object[i].id + '">Archive</a></td>' +
                                    '</tr>';
                        }
                        $('tbody').html(string);
                        $("span.eye-iconClick").removeClass("fa").removeClass("fa-eye-slash").addClass("fa").addClass("fa-eye");
                    }
                });
            }

        });
    });
</script>

<div class="row">
    <div class="col-md-16">

        <!-- START PROJECTS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Conferences</h3>
                    <span>All conferences</span>
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li id="eye-icon"><a href="#" class="showArchieved"><span class="eye-iconClick fa fa-eye"></span></a></li>
                    <li><a href="<?php echo site_url() . '/conference/add'; ?>"><span class="fa fa-plus"></span></a></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="35%">Conference</th>
                                <th width="15%">Start Date</th>
                                <th width="15%">End Date</th>
                                <th width="15%">Status</th>
                                <th width="20%" colspan="3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($conferences as $conference) {
                                echo '<tr>' .
                                '<td><b>' . $conference->naam . '</b></td>' .
                                '<td><span class="label label-success">' . toDDMMYYYY($conference->startdatum) . '</span></td>' .
                                '<td><span class="label label-danger">' . toDDMMYYYY($conference->einddatum) . '</span></td>' .
                                '<td>' .
                                $conference->status->naam .
                                '</td>' .
                                '<td class="actioncol"><a href="' . site_url() . '/conference/modify/' . $conference->id . '">Modify</a></td><td class="actioncol"><a href="' . site_url() . '/conference/manage/' . $conference->id . '">Manage</a></td><td class="actioncol"><a href="' . site_url() . '/conference/archive/' . $conference->id . '">Archive</a></td>' .
                                '</tr>';
                                echo "\n";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!-- END PROJECTS BLOCK -->

    </div>
</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->
