<?php
declare(strict_types=1);

use festival\application\action\GetLieuxAction;
use festival\application\action\GetPanierAction;
use festival\application\action\GetThemesAction;
use festival\application\action\GetTicketByUserAction;
use festival\application\action\HomeAction;
use festival\application\action\GetSoireeAction;
use festival\application\action\GetSpectaclesAction;
use festival\application\action\PostCreateUserAction;
use festival\application\action\PostSigninAction;
use festival\application\middlewares\Cors;
use festival\application\middlewares\JWTAuthMiddleware;

return function (\Slim\App $app): \Slim\App {
    $app->add(new Cors());

    $app->get('/', HomeAction::class)->setName('home');

    // liste spectacles
    $app->get('/spectacles', GetSpectaclesAction::class)->setName('spectacles');

    //liste des themes
    $app->get('/soirees/themes', GetThemesAction::class)->setName('themes');

    // details d'un spectacle
    $app->get('/soirees/{id}', GetSoireeAction::class)->setName('spectacle');

    // liste des lieux
    $app->get('/lieux', GetLieuxAction::class)->setName('lieux');

    // create user
    $app->post('/users/create', PostCreateUserAction::class)->setName('createUser');

    // liste des billets
    $app->get('/users/{id}/billets', GetTicketByUserAction::class)->setName('billets');
        //->add(new JWTAuthMiddleware());

    // signin
    $app->post('/users/signin', PostSigninAction::class)->setName('signin');

    // panier
    $app->get('/panier/{id}', GetPanierAction::class)->setName('panier');

    return $app;
};