<?php
namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\Utilisateur\serviceUtilisateurInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetTicketByUserAction extends AbstractAction{
    private serviceUtilisateurInterface $serviceUtilisateur;

    public function __construct(serviceUtilisateurInterface $serviceUtilisateur){
        $this->serviceUtilisateur = $serviceUtilisateur;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $userId = $args['id'];
        $billets = $this->serviceUtilisateur->getBilletsByUser($userId);
        $data = [
            'type' => 'collection',
            'billets' => $billets,
        ];
        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}