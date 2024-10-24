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

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface {
        try {
            // Récupération et décodage des informations d'autorisation
            $data = $rq->getHeader('Authorization')[0] ?? null;
            if (!$data) {
                return JsonRenderer::render($rs, 401, 'Authorization header missing');
            }

            $authData = str_replace('Basic ', '', $data);
            $decodedData = base64_decode($authData);
            if ($decodedData === false) {
                return JsonRenderer::render($rs, 400, 'Invalid Base64 encoding');
            }

            // Séparation des informations
            list($id_soiree, $quantite, $tarif) = explode(':', $decodedData);


            // Appel du service pour ajouter le billet au panier
            $this->servicePanier->ajouterBilletAuPanier($args['id_user'], (int) $id_soiree, (int) $quantite, (float) $tarif);

            // Réponse réussie
            $rs = $rs->withHeader('Content-Type', 'application/json');
            return JsonRenderer::render($rs, 201, ['message' => 'Billet ajouté avec succès']);
        } catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

}