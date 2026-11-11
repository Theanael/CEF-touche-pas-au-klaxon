<header class="d-flex justify-content-between border align-items-center p-3">
    <h1 class="h5">
        <?php echo $title ?>
    </h1>
    <nav class="d-flex gap-3 align-items-center">
        <?php 
        if($currentUser){
            if ($currentUser->isAdmin()){
        ?> 
            <a class="btn btn-secondary" href="<?php echo $_ENV['URL_ROOT'].'/users'?>">Utilisateurs</a>
            <?php if ($object=="agencies"){?>
                <a class="btn btn-primary" href="<?php echo $_ENV['URL_ROOT'].'/agencies/create'?>">Créer une agence</a>
            <?php }else{?>
                <a class="btn btn-secondary" href="<?php echo $_ENV['URL_ROOT'].'/agencies'?>">Agences</a>
            <?php } ?>

            <?php if ($object=="routes"){?>
                <a class="btn btn-primary" href="<?php echo $_ENV['URL_ROOT'].'/routes/create'?>">Créer un trajet</a>
            <?php }else{?>
                <a class="btn btn-secondary" href="<?php echo $_ENV['URL_ROOT']?>">Trajets</a>
            <?php } ?>

            <?php }else {?> 
            <a class="btn btn-dark" href="<?php echo $_ENV['URL_ROOT']?>/route/create">Créer un trajet</a>
            <?php }?>
            <span>Bonjour <?php echo $currentUser->getFullName(); ?></span>
        <?php }?> 
        
            <a class="btn btn-dark" href="<?php echo $_ENV['URL_ROOT'].'/'.($currentUser?'logout':'login') ?>">
                <?php echo ($currentUser?'Déconnexion':'Connexion') ?>
            </a>

        
        </a>
    </nav>
</header>