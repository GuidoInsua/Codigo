<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

require_once '../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function ($request, $response, array $args) {
		$response->getBody()->write("Funciona!");
return $response;
});

$app->get("/test", function(Request $request, Response $response, array $args){
    // $_GET
    $params = $request->getQueryParams();

    $response->getBody()->write(json_encode($params));
    return $response;
});

$app->run();

?>
