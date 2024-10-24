<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\panier\servicePanier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostValidatePanierAction extends AbstractAction{
    private servicePanier $servicePanier;

    public function __construct(servicePanier $servicePanier){
        $this->servicePanier = $servicePanier;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{


        $this->servicePanier->validatePanier($args['id_user']);

        $rs = $rs->withHeader('Content-type', 'application/json');
        return $rs->withStatus(201);
    }
}