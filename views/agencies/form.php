<form method="POST" action="<?= $_ENV['URL_ROOT'].'/agencies/'.$action=="edit"?$id."/edit":$action ?>" >
    <div class="form-floating mb-3">
        <input
            type="text"
            class="form-control"
            id="name"
            name="name"
            <?php if(!empty($agency)) echo 'value="'.$agency['name'].'"'?>
            required
        >
        <label for="start_time">Nom </label>
    </div>

    <button type="submit" class="btn btn-primary">
        <?php if($action=="create"){
            echo 'Créer l\'agence'; 
        }elseif($action=="edit"){
            echo 'Enregistrer';
        }
        ?>
    </button>

</form>