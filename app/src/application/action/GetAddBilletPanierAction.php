<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\panier\servicePanier;
use festival\core\services\panier\servicePanierInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAddBilletPanierAction extends AbstractAction{
    private servicePanierInterface $servicePanier;

    public function __construct(servicePanier $servicePanier){
        $this->servicePanier = $servicePanier;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        var_dump($args);
        $this->servicePanier->ajouterBilletAuPanier($args['id_panier'], (int) $args['id_soiree'], $args['quantite']);
        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 201);
    }
}