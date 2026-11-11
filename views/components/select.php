<div class="form-floating">
    <select class="form-select"
        name="<?php echo $select['name'] ?>" 
        id=""
    >
        <option value=""></option> <?php //colonne vide pour ne rien pré-remplir par défaut?>
        <?php foreach($select['options']as $option){?> 
            <option 
                value="<?php echo $option['value']?>" 
                <?php if(!empty($select['selected']) && $option['value']==$select['selected']) echo 'selected="1"' //sert quand on veut conserver la sélection après un traitement (en cas d'erreur par exemple) ?>
            >
                <?php echo $option['label']?>
            </option>
        <?php } ?>
    </select>
    <label for="<?php echo $select['name'] ?>">
        <?php echo $select['label']?>
    </label>
</div>