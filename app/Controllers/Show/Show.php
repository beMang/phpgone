<?php

namespace app\Controllers\Show;

use phpGone\Renderer\Renderer;

class Show extends \phpGone\Core\BackController
{
    public function index(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->getRenderer()->twigRender('Show/index.twig', []);
    }

    public function doc(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->getRenderer()->twigRender('Show/index.twig', []);
        $this->getRenderer()->render('Show/doc', []);
    }
}
