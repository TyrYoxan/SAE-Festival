<?php
declare(strict_types=1);

use festival\application\actions\HomeAction;
use festival\application\actions\SoireeAction;
use festival\application\actions\GetSpectaclesAction;
use festival\application\middlewares\Cors;

return function (\Slim\App $app): \Slim\App {
    $app->add(Cors::class);

    $app->get('/', HomeAction::class)->setName('home');

    // liste spectacles
    $app->get('/spectacles', GetSpectaclesAction::class)->setName('spectacles');

    // details d'un spectacle
    $app->get('/soirees/{id}', SoireeAction::class)->setName('spectacle');

    return $app;
};