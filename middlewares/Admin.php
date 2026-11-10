<?php

use Buki\Router\Http\Middleware;

class Admin extends Middleware
{
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