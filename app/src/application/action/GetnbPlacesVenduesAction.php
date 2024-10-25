<?php
namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\soirees\serviceSoireeInterface;
use Psr\Http\Message\ResponseInterface;

use Psr\Http\Message\ServerRequestInterface;

class GetnbPlacesVenduesAction extends AbstractAction{
    private serviceSoireeInterface $serviceSoiree;

    public function __construct(serviceSoireeInterface $serviceSoiree){
        $this->serviceSoiree = $serviceSoiree;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $soireeId = $args['id_soiree'];
        $placesVendues = $this->serviceSoiree->getPlacesVendues($soireeId);
        $data = [
            'type' => 'ressource',
            'placesVendues' => $placesVendues[0],
            'placesDisponibles' => $placesVendues[1],
        ];
        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}