<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\soirees\serviceSoireeInterface;
use festival\core\services\soirees\serviceSoirees;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteContext;

class GetSoireeAction extends AbstractAction{
    private serviceSoireeInterface $serviceSoirees;

    public function __construct(serviceSoireeInterface $serviceSoirees){
        $this->serviceSoirees = $serviceSoirees;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $soiree = $this->serviceSoirees->getSpectacles($args['id']);
        $routeContext = RouteContext::FromRequest($rq);
        $routeParser = $routeContext->getRouteParser();

        $data = [
            'type' => 'collection',
            'soiree' => $soiree[0],
        ];

        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}