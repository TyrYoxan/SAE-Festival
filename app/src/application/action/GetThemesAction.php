<?php

namespace festival\application\action;

use festival\application\action\AbstractAction;
use festival\application\renderer\JsonRenderer;
use festival\core\services\themes\serviceThemesInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetThemesAction extends AbstractAction{

    private serviceThemesInterface $serviceThemes;

    public function __construct(serviceThemesInterface $serviceThemes){
        $this->serviceThemes = $serviceThemes;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface{
        $theme = $this->serviceThemes->getThemes();
        $data = [
            'type' => 'collection',
            'theme' => $theme,
        ];

        $rs = $rs->withHeader('Content-type', 'application/json');
        return JsonRenderer::render($rs, 200, $data);
    }
}