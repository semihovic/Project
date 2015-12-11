
<?php
$attributes = array('name' => 'myform', 'id' => 'formContact');
echo form_open('contact/contacteer', $attributes);
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>



<script type="text/javascript">

    var mapCords = new google.maps.LatLng(51.160715, 4.961986);
    var mapOptions = {zoom: 14, center: mapCords, mapTypeId: google.maps.MapTypeId.ROADMAP}
    var map = new google.maps.Map(document.getElementById("google-map"), mapOptions);

    var cords = new google.maps.LatLng(51.160715, 4.961986);
    var marker = new google.maps.Marker({position: cords,
        map: map,
        title: "Thomas More Kempen",
        icon: 'http://aqvatarius.com/development/atlant-frontend/img/map-marker.png'}
    );

</script>
<div class="row">
    <div class="col-md-7 this-animate" data-animate="fadeInLeft">
        <h1>Contact </h1>
        <div class="text-column">
            <h4></h4>
            <div class="text-column-info">

                <div class="text-column-info">
                    Please fill in the following form in order to contact us. <br /> 
                </div>
            </div>
            <br />
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Name:', 'naam'); ?>
                    <?php
                    if (!empty($user)) {
                        echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'readonly' => 'true', 'value' => $user->voornaam . " " . $user->achternaam));
                    } else {
                        echo form_input(array('name' => 'naam', 'id' => 'naam', 'class' => 'form-control', 'value' => ""));
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo form_label('Email:', 'email'); ?>
                    <?php
                    if (!empty($user)) {
                        echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'readonly' => 'true', 'value' => $user->email));
                    } else {
                        echo form_input(array('name' => 'email', 'id' => 'email', 'class' => 'form-control', 'value' => ""));
                    }
                    ?>
                </div>
            </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <?php echo form_label('Subject:', 'onderwerp'); ?>
                        <?php echo form_input(array('name' => 'onderwerp', 'id' => 'onderwerp', 'class' => 'form-control')); ?>
                    </div>
                    <div class="form-group">
                        <?php echo form_label('Message:', 'bericht'); ?>
                        <?php echo form_textarea(array('name' => 'bericht', 'id' => 'bericht', 'class' => 'form-control', 'rows' => 8)); ?>
                    </div>
                    <?php
                    $data = array('name' => 'mysubmit', 'value' => 'Submit', 'size' => '30', 'class' => 'btn btn-primary');
                    echo form_submit($data);
                    ?> &nbsp;<?php
                    $data = array('name' => 'mysubmit', 'value' => 'Back', 'size' => '30', 'class' => 'btn btn-primary');
                    echo form_submit($data);
                    ?>
                </div>
            </div>
        </div>
        <<div class="col-md-5 this-animate" data-animate="fadeInRight">

            <div class="text-column text-column-centralized">
                <div class="text-column-icon">
                    <span class="fa fa-home"></span>
                </div>                                    
                <h4>Our Office</h4>
                <div class="text-column-info">
                    <p><strong><span class="fa fa-map-marker"></span> Address: </strong> Kleinhoefstraat 4, 2440 GEEL</p>
                    <p><strong><span class="fa fa-phone"></span> Phone: </strong> +32 14 80 22 10</p>
                    <p><strong><span class="fa fa-envelope"></span> E-mail: </strong> <a href="#">karine.nicolay@thomasmore.be</a></p>
                </div>
            </div>
            <div class="text-column text-column-centralized">
                <div class="text-column-icon">
                    <span class="fa fa-clock-o"></span>
                </div>
                <h4>Bussines Hours</h4>
                <div class="text-column-info">
                    <p><strong>Monday &mdash; Friday</strong>: 10:00am - 6:00pm</p>
                    <p><strong>Saturday &mdash; Sunday</strong>: Closed</p>
                </div>
            </div>
        </div>
    </div>