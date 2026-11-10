<?php

use Buki\Router\Http\Middleware;

class Auth extends Middleware
{
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

