<?php

namespace festival\application\middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;

class Cors
{
    public function __invoke(Request $rq, RequestHandler $next): Response {
        $origin = $rq->hasHeader('Origin') ? $rq->getHeader('Origin')[0] : '*';

        // Gestion des requêtes preflight (OPTIONS)
        if ($rq->getMethod() === 'OPTIONS') {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse();
            return $response
                ->withHeader('Access-Control-Allow-Origin', $origin)
                ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, DELETE, OPTIONS')
                ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                ->withHeader('Access-Control-Max-Age', '3600');
        }

        // Traitement des autres requêtes
        $response = $next->handle($rq);

        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
            ->withHeader('Access-Control-Allow-Credentials', 'true');
    }
}