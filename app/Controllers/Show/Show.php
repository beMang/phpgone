<?php

namespace app\Controllers\Show;

use phpGone\Renderer\Renderer;

class Show extends \phpGone\Core\BackController
{
    public function index()
    {
        Renderer::twigRender('Show/index.twig', []);
    }

    public function doc()
    {
        Renderer::twigRenderWithCache('Show/index.twig', []);
        Renderer::render('Show/doc', []);
    }
}
