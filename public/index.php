<?php require '../vendor/autoload.php';
require '../core/autoloader.php';
require '../core/env_loader.php';

session_start();

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$router = new Router([
    'base_folder' => 'touche-pas-au-klaxon',

    'paths' => [
        'controllers' => dirname(__DIR__) . '/controllers',
        'middlewares' => dirname(__DIR__) . '/middlewares',
    ]
]);





/**
 * Routes
*/

// Page d'Accueil.
$router->get('/', 'RouteController@list');

// Affiche la page de création de trajet.
$router->get('/routes/create','RouteController@creationForm',['before'=>'Auth']);

//Traite la création de trajet puis redirige vers l'accueil.
$router->post('/routes/create','RouteController@create',['before'=>'Auth']);

//Traite la supression de trajet puis redirige vers l'accueil.
$router->get('/routes/:id/delete','RouteController@delete',['before'=>'Auth']);


//Traite la modification de trajet puis redirige vers l'accueil.
$router->get('/routes/:id/edit','RouteController@editionForm',['before'=>'Auth']);

//Traite la modification de trajet puis redirige vers l'accueil.
$router->post('/routes/:id/edit','RouteController@edit',['before'=>'Auth']);


/**
 * Connexion & Utilisateur
*/

// Affiche la liste des utilisateurs
$router->get('/users','UserController@list',['before'=>'Admin']);

// Affiche la page de connexion.
$router->get('/login','UserController@loginPage',['before'=>'Guest']);

// Traite les données de connexion puis redirige vers l'accueil.
$router->post('/login','UserController@login',['before'=>'Guest']);

//Déconnecte l'utilisateur puis redirige vers l'accueil.
$router->get('/logout','UserController@logout');


/**
 * Agences 
 */

//Affiche la liste des agences.
$router->get('/agencies','AgencyController@list',['before'=>'Admin']);

//Traite la suppression d'une agence
$router->get('/agencies/:id/delete','AgencyController@delete',['before'=>'Admin']);

//Affiche le formulaire de création d'agence
$router->get('agencies/create','AgencyController@creationForm',['before'=>'Admin']);

// Traite la création d'une agence
$router->post('agencies/create','AgencyController@create',['before'=>'Admin']);

//Affiche le formulaire d'édition d'agences
$router->get('agencies/:id/edit','AgencyController@editionForm',['before'=>'Admin']);

// Traite la modification d'une agence.
$router->post('agencies/:id/edit','AgencyController@edit',['before'=>'Admin']);

$router->run();