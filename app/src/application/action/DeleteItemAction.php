<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\panier\servicePanierInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DeleteItemAction extends AbstractAction{
    protected servicePanierInterface $servicePanier;

    public function __construct(servicePanierInterface $servicePanier){
        $this->servicePanier = $servicePanier;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $id_item = $args['item'];
            $id_user = $args['id_user'];
            $this->servicePanier->deleteItem($id_item, $id_user);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        return JsonRenderer::render($rs, 200, ['message' => 'Billet supprime avec succes']);
    }
}