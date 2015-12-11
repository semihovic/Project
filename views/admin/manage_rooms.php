
<div class="row">
    <div class="col-md-16">

        <!-- START ROOMS BLOCK -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title-box">
                    <h3>Rooms</h3>
                    <span>All rooms for this conference</span>
                </div>                                    
                <ul class="panel-controls" style="margin-top: 2px;">
                    <li><a href="<?php echo site_url() . '/room/add'; ?>"><span class="fa fa-plus"></span></a></li>                               
                </ul>
            </div>
            <div class="panel-body panel-body-table">
                <?php if (!empty($rooms)) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="80%">Name</th>
                                    <th width="20%" colspan="2">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($rooms as $room) {
                                    echo '<tr>' .
                                    '<td class="room' . $room->id . '"><strong>' . $room->naam . '</strong></td>' .
                                    '<td class="actioncol"><a href="#" class="editRoom" data-id="' . $room->id . '" data-naam="' . $room->naam . '">Modify</a></td><td class="actioncol"><a href="' . site_url() . '/room/delete/' . $room->id . '">Delete</a></td>' .
                                    '</tr>';
                                    echo "\n";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
<?php } else {
    echo "No rooms yet";
} ?>

            </div>
        </div>
        <!-- END ROOMS BLOCK -->

    </div>
</div>

<script>
    $(document).ready(function () {
        var id = 0;
        var naam = 0;
        var oldNew = 0;
        var oldNaam = 0;

        $(".editRoom").click(function (e) {
            e.preventDefault();
            if (oldNew !== id) {
                oldNew = id;
                oldNaam = naam;
                $(".room" + oldNew).html(oldNaam);
            }
            id = $(this).data("id");
            naam = $(this).data("naam");

            $(".room" + id).html('<input type="text" value="' + naam + '" class="roomChange" data-id="' + id + '"/> Press enter to confirm the change!');
            maakkeypress();
        });
    });

    function maakkeypress() {
        $(".roomChange").keydown(function (event) {
            if (event.keyCode === 13) {
                var roomValue = $(".roomChange").val();
                var id = $(this).data("id");
                $.ajax({type: "POST",
                    url: "<?php echo site_url() ?>/room/modify",
                    data: {roomId: id, room: roomValue},
                    async: false,
                    success: function (result) {
                        var object = jQuery.parseJSON(result);
                        $(".room" + object.id).html(object.naam);
                        document.location.reload(true);
                    }
                });
            }
        });
    }
</script>

</div>
<!-- END PAGE CONTENT WRAPPER -->
