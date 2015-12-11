<?php //

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<script>
    $(document).ready(function() {
        $('#info').hide();
        
        $('#infoKlik').click(function(e) {
            e.preventDefault();
            $('#info').show();
        });
        
        $("#infoHide").click(function(e) {
          e.preventDefault();
          $('#info').hide();
        });
    });
</script>

<div id="title">
	<h1>Statistics</h1>
</div>

<div id="info">
    <h2>Select variables</h2>
    <p>Keep track of the amount of visitors on your website. Choose the desired graph to display these statistics.
    </p>    
    
    <p>
            Variable X
            <select name="formGender">
                <option value="">Select...</option>
                <option value="Visitors">Visitors</option>
                <option value="Speakers">Speakers</option>
            </select>
    </p>
    
    <p>
            Variable Y
            <select name="formGender">
                <option value="">Select...</option>
                <option value="Days">Days</option>
                <option value="Weeks">Weeks</option>
                <option value="Months">Months</option>
                <option value="Years">Years</option>
            </select>
    </p>
</div>


