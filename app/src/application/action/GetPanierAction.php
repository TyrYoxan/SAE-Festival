<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\panier\servicePanier;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPanierAction extends AbstractAction{

    private servicePanier $servicePanier;

    public function __construct(servicePanier $servicePanier){
        $this->servicePanier = $servicePanier;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $panier = $this->servicePanier->getPanier($args['id_user']);
        $data = [
            'type' => 'collection',
            'panier' => $panier[0] ?? [],
        ];
        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}