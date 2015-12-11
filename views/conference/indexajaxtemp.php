<table> 
    <tr> 
        <th>Conferentie</th> 
        <th>Naam</th>
        <th>Beginuur</th> 
        <th>Einduur</th> 
        <th>Beschrijving</th> 
        <th>Lokaal</th> 
        <th>Parrallel</th> 
    </tr>
 
   <?php foreach($sessies as $sessie) { ?>
    <tr>
        <td> <?php echo $sessie->conferentie->naam; ?></td> 
        <td> <?php echo $sessie->naam;?></td> 
        <td> <?php echo $sessie->beginuur;?></td>  
        <td> <?php echo $sessie->einduur;?> </td> 
        <td> <?php echo $sessie->beschrijving;?> </td> 
        <td> <?php echo $sessie->lokaal->naam;?> </td> 
        <td> <?php echo $sessie->isParallel;?> </td> 
    </tr>
    <?php } ?>
</table>