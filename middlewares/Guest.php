<?php

use Buki\Router\Http\Middleware;
/**
 * Middleware utilisé pour empêcher un utilisateur connecté d'accéder à la page de connexion
 */
class Guest extends Middleware
{
    public function handle()
    {
        if (!empty($_SESSION['user'])) {
            $db = Database::getDb();
            $user = new User($db);

            $user->findById($_SESSION['user']);

            View::render('error', [
                'currentUser' => $user,
                'title' => 'Touche pas au klaxon',
                'footer' => [
                    'date' => 2026,
                    'company' => 'CENEF',
                    'site' => 'MVC PHP'
                ],
                'error' => [
                    'code' => 403,
                    'message' => 'Vous êtes déjà connecté.'
                ],
            ]);
            return false;
        }
        

        return true;
    }
}