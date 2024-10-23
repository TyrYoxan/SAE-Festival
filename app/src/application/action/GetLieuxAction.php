<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\lieux\serviceLieuxInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetLieuxAction extends AbstractAction{
    private serviceLieuxInterface $serviceLieux;

    public function __construct(serviceLieuxInterface $serviceLieux){
        $this->serviceLieux = $serviceLieux;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $lieux = $this->serviceLieux->getLieux();
        $data = [
            'type' => 'collection',
            'lieux' => $lieux,
        ];
        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}