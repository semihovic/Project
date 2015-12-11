<style>
    .signStatus {
        font-size:20px;
    }
    .signStatus h1 {font-size:25px;}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-6 signStatus">
            <h1> Sign Report </h1>
            
            <p>Dear <b><?php echo $user->voornaam;?> <?php echo $user->achternaam;?></b> </p>
            <p>&nbsp;</p>
            <p>Thank you for trying to sign for a conference. </p>
            <?php if (!$success) { ?>
            <span class="warning">
                <p> Sadly, there was an error trying to proccess your request. </p>
                <p> There could be several reasons where our systems failed: </p>
                <ul>
                    <li>You were already signed for every day/activity on the conference. Please keep in mind that if you are logged in
                        before selecting the days, the days that you are already signed up for will be filtered by our system to avoid these kinds of problems. </li>
                    <li>You have selected no days/activities so sign up for. </li>
                    <li>You came here in a way that is not allowed. </li>
                </ul>
                <p> <b>If this error keeps occuring and you are sure you followed the correct steps, notify an administrator through the contact page and he will help you further. </b></p>
            </span>
            
            <?php } else { ?>
            <p>Our systems are processing your request and the administrators will be notified as soon as possible. </p>
            <p>As soon as our administrators are notified, they will contact you for the payment. Our system does not have an automated payment system, 
                so the whole process will not be automatic. There will be a conversation between you and the administrator in order to succeed the payment. </p>
            <p>If you fail to pay before the day the administrator has told you, your subscription will be cancelled. </p>
            
            <p class="info">A reminder of the price: €<?php echo $prijs;?></p>
            <p><b>If this price is less then earlier shown, it was means you were already signed for those days in the conference.</b></p>
            
            <p>We hope to see you at the conference. </p>
            <?php } ?>
            
            
            
        </div>
    </div>
    
</div>