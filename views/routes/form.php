<form method="POST" action="<?= $_ENV['URL_ROOT'].'/route/'.$action=="edit"?$id."/edit":$action ?>" >

    <p >Départ</p>
    <?php
        $select = [
            'name' => 'start_at',
            'label' => 'Agence',
            'options' => $agency_options
        ];
        if(!empty($route)){
            $select['selected'] = $route['start_at'];
        }
        require __DIR__.'/../components/select.php';
    ?>
    <div class="form-floating mb-3">
        <input
            type="datetime-local"
            class="form-control"
            id="start_time"
            name="start_time"
            <?php if(!empty($route)) echo 'value="'.$route['start_time'].'"'?>
            required
        >
        <label for="start_time">Date et heure </label>
    </div>

    <p >Destination</p>

    <?php
        $select = [
            'name' => 'end_at',
            'label' => 'Agence',
            'options' => $agency_options,
            
        ];

        if(!empty($route)){
            $select['selected'] = $route['end_at'];
        }
        require __DIR__.'/../components/select.php';
    ?>

    <div class="form-floating mb-3">
        <input
            type="datetime-local"
            class="form-control"
            id="end_time"
            name="end_time"
            <?php if(!empty($route)) echo 'value="'.$route['end_time'].'"'?>
            required
        >
        <label for="end_time">Date et heure</label>
    </div>

    <div class="mb-3">
        <label class="form-label">Places </label>
        <div class="input-group">
            <input
                type="number"
                class="form-control"
                id="seats_taken"
                name="seats_taken"
                value="0"
                min="0"
                placeholder="Occupées"
                <?php if(!empty($route)) echo 'value="'.$route['seats_taken'].'"'?>
                required
            >
            <span class="input-group-text">/</span>
            <input
                type="number"
                class="form-control"
                id="seats_total"
                name="seats_total"
                min="1"
                placeholder="Capacité totale"
                required
                <?php if(!empty($route)) echo 'value="'.$route['seats_total'].'"'?>
            >
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <?php if($action=="create"){
            echo 'Créer le trajet'; 
        }elseif($action=="edit"){
            echo 'Enregistrer';
        }
        ?>
    </button>

</form>