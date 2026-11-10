<h2>
    
    <?php if (!$currentUser){
        echo "Pour obtenir plus d'informations sur un trajet, veuillez vous connecter";
    }else{
        echo 'Trajets proposés';
    }    

    ?>
</h2>
<?php 
?>
<?php 
require_once __DIR__ .'/../components/table.php'; 
require_once __DIR__ .'/details.php'
?>

