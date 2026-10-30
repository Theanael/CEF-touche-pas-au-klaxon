<?php require '../vendor/autoload.php';

require '../core/env_loader.php';
require '../core/db.php';

use Buki\Router\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$router = new Router([
    'base_folder'=>'touche-pas-au-klaxon'
]);

// For basic GET URI
$router->get('/', function(Request $request, Response $response) {
    $response->setContent('Hello World ');
    return $response;

    # OR
    # return 'Hello World!';
});


$router->run();