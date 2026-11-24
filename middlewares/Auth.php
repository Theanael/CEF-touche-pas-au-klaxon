<?php

use Buki\Router\Http\Middleware;

/**
 * Middleware utilisé pour empêcher un utilisateur déconnecté d'accéder à certaines pages.
 */
class Auth extends Middleware
{    /**
     * handle
     * vérifie si l'utilisateur est connecté et affiche une erreur sinon.
     * @return Bool true si l'utilisateur est connecté, false sinon.
     */
    public function handle()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        View::render('error', [
            'currentUser'=>null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'error'=>['code'=>401,'message'=>"Vous devez être connecté pour accéder à cette page."],
        ]);
        return false;
    }
}

