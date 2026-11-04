<table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <?php foreach ($table_columns as $col) {
                echo '<th>'.$col['label'].'</th>';
            } ?>
        </tr>
    </thead>
    <tbody class="">
        <?php foreach($table_data as $row){
            ?> <tr><?php
            foreach($table_columns as $col){
                if($col['name']=="actions"){
                    ?>
                    <td class="d-flex justify-content-around">
                        <a class="link-dark link-underline-opacity-0" href="<?php echo $_ENV['URL_ROOT']?>/route/<?php echo $row['id']; ?>/details">
                            <i class="bi bi-eye "></i>
                        </a>

                        <?php if ($row['editable']){?>
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