<?php

namespace app\Controllers\Demo;

use phpGone\Renderer\Renderer;

/**
 * Controller basique
 */
class Show extends \phpGone\Core\BackController
{
    protected $mainView;

    public function setUp()
    {
        $this->mainView = 'Demo/index.twig';
    }

    public function index()
    {
        Renderer::twigRender($this->mainView, []);
    }

    public function doc()
    {
        Renderer::twigRender('Demo/index.twig', [], true);
        Renderer::render('Demo/doc', []);
    }
}
