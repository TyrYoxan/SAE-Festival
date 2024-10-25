<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\Utilisateur\serviceUtilisateurInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostCreateUserAction extends AbstractAction{
    private serviceUtilisateurInterface $serviceUtilisateur;

    public function __construct(serviceUtilisateurInterface $serviceUtilisateur){
        $this->serviceUtilisateur = $serviceUtilisateur;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $data = $rq->getParsedBody();
        try {
            if(!filter_var( $data['email'], FILTER_VALIDATE_EMAIL)){
                throw new \Exception('Email invalide');
            }
            $pwd = password_hash($data['password'], PASSWORD_BCRYPT);

            $this->serviceUtilisateur->createUser(strip_tags($data['name']), $data['email'], $pwd);
            return JsonRenderer::render($rs, 201, ['message' => 'Utilisateur cree avec succees']);
        }catch (\Exception $th) {
            return JsonRenderer::render($rs, 500, $th->getMessage());
        }
    }
}