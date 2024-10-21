<?php

namespace festival\application\actions;

use festival\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use serviceSpectacleInterface;
use Slim\Routing\RouteContext;
use toubeelib\application\renderer\JsonRenderer;

class GetSpectaclesAction extends AbstractAction{
    private serviceSpectacleInterface $serviceSpectacle;

    public function __construct(serviceSpectacleInterface $serviceSpectacle){
        $this->serviceSpectacle = $serviceSpectacle;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response{
        $spectacle = $this->serviceSpectacle->getSpectacles();

        $routeContext = RouteContext::FromRequest($rq);
        $routeParser = $routeContext->getRouteParser();

        $data = [
            'type' => 'collection',
            'spectacles' => $spectacle,
        ];

        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}