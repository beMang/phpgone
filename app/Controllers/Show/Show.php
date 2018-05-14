<?php

namespace app\Controllers\Show;

use phpGone\Renderer\Renderer;

class Show extends \phpGone\Core\BackController
{
    public function index()
    {
        $this->getRenderer()->twigRender('Show/index.twig', []);
    }

    public function doc()
    {
        $this->getRenderer()->twigRenderWithCache('Show/index.twig', []);
        $this->getRenderer()->render('Show/doc', []);
    }
}
