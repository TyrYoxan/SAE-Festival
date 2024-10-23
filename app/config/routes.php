<?php
declare(strict_types=1);

use festival\application\action\GetThemesAction;
use festival\application\action\HomeAction;
use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\application\middlewares\Cors;

return function (\Slim\App $app): \Slim\App {
    //$app->add(Cors::class);

    $app->get('/', HomeAction::class)->setName('home');

    // liste spectacles
    $app->get('/spectacles', GetSpectaclesAction::class)->setName('spectacles');

    //liste des themes
    $app->get('/soirees/themes', GetThemesAction::class)->setName('themes');

    // details d'un spectacle
    $app->get('/soirees/{id}', GetSoireeAction::class)->setName('spectacle');



    return $app;
};