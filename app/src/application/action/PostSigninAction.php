<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\providers\auth\JWTAuthnProvider;
use festival\core\domain\entities\Utilisateur\Utilisateur;
use festival\core\Dto\DtoCredentials;
use festival\core\ReposotiryInterfaces\UtilisateurRepositoryInterface;
use festival\core\services\Utilisateur\serviceUtilisateurInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostSigninAction extends AbstractAction{
    protected UtilisateurRepositoryInterface $serviceUtilisateur;

    public function __construct(UtilisateurRepositoryInterface $serviceUtilisateur){
        $this->serviceUtilisateur = $serviceUtilisateur;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $data = $rq->getHeader('Authorization')[0];
        $authData = str_replace('Basic ', '', $data);

        // Décodage de la chaîne Base64
        $decodedData = base64_decode($authData);

        // Séparation des informations username:password
        list($username, $password) = explode(':', $decodedData);

        if (!isset($username) || !isset($password)) {
            $rs->getBody()->write('Email and password are required.');
            return $rs->withStatus(400);
        }

        $credentials = new DtoCredentials($username, $password);
        try {
            $jwtAuthnProvider = new JWTAuthnProvider($this->serviceUtilisateur);
            $auth = $jwtAuthnProvider->signin($credentials);
            $responseBody = [
                'atoken' => $auth->atoken,
                'rtoken' => $auth->rtoken
            ];

            $rs->getBody()->write(json_encode($responseBody));
            return $rs->withStatus(201)
                ->withHeader('Content-Type', 'application/json');

        } catch (\Exception $e) {
            $rs->getBody()->write($e->getMessage());
            return $rs->withStatus(401);
        }
    }
}