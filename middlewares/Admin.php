<?php

use Buki\Router\Http\Middleware;
/**
 * Middleware utilisé pour verouiller le panel administrateur aux administrateurs.
 */
class Admin extends Middleware
{
    /**
     * handle
     * vérifie si l'utilisateur connecté est un administrateur et affiche une erreur sinon.
     * @return Bool true si l'utilisateur est administrateur, false sinon.
     */
    public function handle()
    {
        $user;
        if (isset($_SESSION['user'])) {
            $user = new User(Database::getDb());
            if($user->findById($_SESSION['user'])){
                if($user->isAdmin()){
                    return true;
                }
            }
        }

        View::render('error', [
            'currentUser'=>$user??null,
            'title' => 'Touche pas au klaxon',
            'footer'=>['date'=>2026,'company'=>'CENEF','site'=>'MVC PHP'],
            'error'=>['code'=>403,'message'=>"Vous devez être administrateur pour accéder à cette page."],
        ]);
        return false;
    }
}