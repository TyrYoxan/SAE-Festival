<?php

use DI\ContainerBuilder;
use festival\application\utils\CorsUtility;
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use festival\application\middlewares\Cors;


$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');
$c=$builder->build();
$app = AppFactory::createFromContainer($c);


$app->addBodyParsingMiddleware();
$app->add(Cors::class);
$app->addRoutingMiddleware();
//$app->add(new Cors());
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false)
    ->getDefaultErrorHandler()
    ->forceContentType('application/json');


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;