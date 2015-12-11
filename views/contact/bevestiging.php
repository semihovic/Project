<?php

?>


<h4><?php echo $title; ?></h4>

<p>Thank you for contacting us.</p>
<p>We will try to respond as soon as possible</p>
<p><?php
$data = array('name' => 'mysubmit', 'value' => 'Back', 'size' => '30', 'class' => 'btn btn-primary');
echo anchor('home/index',form_submit($data));?></p>