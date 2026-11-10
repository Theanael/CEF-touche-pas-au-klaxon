<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <?php foreach ($table_columns as $col) { // on affiche l'entête du tableau, colonne par colonne
                echo '<th>'.$col['label'].'</th>';
            } ?>
        </tr>
    </thead>
    <tbody class="">
        <?php foreach($table_data as $row){
            ?> <tr><?php
            foreach($table_columns as $col){
                if($col['name']=="actions"){ // nom de colonne spéciale qui permet d'afficher les boutons d'actions
                    ?>
                    <td class="d-flex justify-content-around text-center">
                        <a 
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#exampleModal"
                            class="link-dark link-underline-opacity-0" 


                            <?php foreach($row['details']??[] as $key => $value){ // on rajoutes les éventuelles données pour le js
                                echo 'data-'.$key.'="'.$value.'" '; 
                            } ?>
                        >
                            <i class="bi bi-eye "></i>
                        </a>

                        <?php if ($row['editable']){ // si l'utilisateur a le droit de modifier le trajet on affiche les boutons correspondants?>
                        <a class="link-dark link-underline-opacity-0"  href="<?php echo $_ENV['URL_ROOT']?>/route/<?php echo $row['id']; ?>/edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a class="link-dark link-underline-opacity-0"  href="<?php echo $_ENV['URL_ROOT']?>/route/<?php echo $row['id']; ?>/delete">
                            <i class="bi bi-trash3"></i>
                        </a>
                        <?php } ?>
                    </td>
                    <?php
                }else{
                    echo '<td>'.$row[$col['name']].'</td>';
                }
            }
            ?> 
            </tr> 
            <?php } ?>
    </tbody>
</table>