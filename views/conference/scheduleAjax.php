<h1> <?php echo $sessies[0]->conferentie->naam?> </h1>
<h2> Days </h2>
<table> 
    <tr> 
        <th>Naam</th>
        <th>Spreker</th>
        <th>Beginuur</th> 
        <th>Einduur</th> 
        <th>Beschrijving</th> 
        <th>Lokaal</th> 
        <th>Parrallel</th> 
    </tr>
 
   <?php foreach($sessies as $sessie) { ?>
    <tr>
        <td> <?php echo $sessie->naam;?></td> 
        <td> Test</td>
        <td> <?php echo $sessie->beginuur;?></td>  
        <td> <?php echo $sessie->einduur;?> </td> 
        <td> <?php echo $sessie->beschrijving;?> </td> 
        <td> <?php echo $sessie->lokaal->naam;?> </td> 
        <td> <?php echo $sessie->isParallel;?> </td> 
    </tr>
    
    <?php } ?>
</table>


<button type="submit" value="Inschrijven"><?php echo anchor('conference/sign/' . $sessies[0]->conferentie->id, 'Inschrijven');?> </button>