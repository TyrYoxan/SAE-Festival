<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAddBilletPanierAction extends AbstractAction{
    private $servicePanier;

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // TODO: Implement __invoke() method.
    }
}