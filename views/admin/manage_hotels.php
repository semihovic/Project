
    <div class="row">
        <div class="col-md-16">

            <!-- START HOTELS BLOCK -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title-box">
                        <h3>Hotels</h3>
                        <span>All hotels near this conferences</span>
                    </div>                                    
                    <ul class="panel-controls" style="margin-top: 2px;">
                        <li><a href="<?php echo site_url() . '/hotel/add';?>"><span class="fa fa-plus"></span></a></li>                               
                    </ul>
                </div>
                <div class="panel-body panel-body-table">
                    <?php if(!empty($hotels)){?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="26.6%">Name</th>
                                    <th width="26.6%">Place</th>
                                    <th width="26.6%">Website</th>
                                    <th width="20%" colspan="3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($hotels as $hotel) {
                                    echo '<tr>' .
                                        '<td><strong>' . $hotel->naam . '</strong></td>' .
                                        '<td>' . $hotel->plaats . '</span></td>' .
                                        '<td>'.
                                        anchor("http://" . $hotel->website,$hotel->website) .
                                        '</td>' .
                                        '<td class="actioncol"><a href="' . site_url() . '/hotel/modify/' . $hotel->id . '">Modify</a></td><td class="actioncol"><a href="' . site_url() . '/hotel/delete/' . $hotel->id . '" onclick="return myFunction();">Delete</a></td>' .
                                        '</tr>';
                                    echo "\n";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } else { echo "No hotels yet";}?>

                </div>
            </div>
            <!-- END HOTELS BLOCK -->

        </div>
    </div>
    
<script>
    function myFunction() {
        var r = confirm("Are you sure you want to delete this hotel?");
        if (r == true) {
            return true;
        } else {
            return false;
        }
    }
</script>

</div>
<!-- END PAGE CONTENT WRAPPER -->
