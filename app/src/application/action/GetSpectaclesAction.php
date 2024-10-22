<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use festival\core\services\spectacles\serviceSpectacleInterface;
use Slim\Routing\RouteContext;

class GetSpectaclesAction extends AbstractAction{
    private serviceSpectacleInterface $serviceSpectacle;

    public function __construct(serviceSpectacleInterface $serviceSpectacle){
        $this->serviceSpectacle = $serviceSpectacle;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response{
        try{
            $spectacle = $this->serviceSpectacle->getSpectacles();

            $routeContext = RouteContext::FromRequest($rq);
            $routeParser = $routeContext->getRouteParser();

            $data = [
                'type' => 'collection',
                'spectacles' => $spectacle,
            ];

            $rs = $rs->withHeader('Content-type', 'application/json');
            return JsonRenderer::render($rs, 200, $data);

        }catch (\Throwable $th){
            $rs = $rs->withHeader('Content-type', 'application/json');
            return JsonRenderer::render($rs, 500, $th->getMessage());
        }

    }
}