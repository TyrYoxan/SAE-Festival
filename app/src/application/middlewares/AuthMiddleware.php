<?php

namespace festival\application\middlewares;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use festival\core\services\authorization\ServiceAuthz;

class AuthMiddleware{

    private $authzService;

    public function __construct(ServiceAuthz $authzService) {
        $this->authzService = $authzService;
    }
    public function __invoke(Request $rq, Response $rs, RequestHandlerInterface $next): Response{

        $auth = $rq->getAttribute('auth');

        $practitionerId = (int) $rq->getAttribute('practitioner_id');

        // Vérifier si l'utilisateur peut accéder au praticien
        if (!$this->authzService->authRead($auth)) {
            return $rq->withStatus(403)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode(['error' => 'Access denied']));
        }

        return $next->handle($rq);
    }
}