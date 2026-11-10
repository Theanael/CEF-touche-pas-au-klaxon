<header class="d-flex justify-content-between border align-items-center p-3">
    <h1 class="h5">
        <?php echo $title ?>
    </h1>
    <nav class="d-flex gap-3 align-items-center">
        <?php 
        if($currentUser){
            if ($currentUser->isAdmin()){
        ?> 
            <a class="btn btn-secondary" href="">Utilisateurs</a>
            <a class="btn btn-secondary" href="">Agences</a>
            <a class="btn btn-secondary" href="">Trajets</a>
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