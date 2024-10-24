<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\panier\servicePanier;
use festival\core\services\panier\servicePanierInterface;
use festival\core\services\soirees\serviceSoireeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostPayerPanierAction extends AbstractAction{
    private servicePanierInterface $servicePanier;
    private serviceSoireeInterface $serviceSoiree;


    public function __construct(servicePanier $servicePanier, serviceSoireeInterface $serviceSoiree){
        $this->serviceSoiree = $serviceSoiree;
        $this->servicePanier = $servicePanier;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $id = $args['id_user'];
        try {
            $data = $rq->getParsedBody();
            if($this->serviceSoiree->verfierPlace($data['id_soiree'])){
                $this->servicePanier->payerPanier($id);
                $rs = $rs->withHeader('Content-type', 'application/json');
                return JsonRenderer::render($rs, 200);
            }else{
                return JsonRenderer::render($rs, 400);
            }

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}