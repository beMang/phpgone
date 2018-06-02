<?php

namespace app\Controllers\Show;

use phpGone\Renderer\Renderer;

/**
 * Controller basique
 */
class Show extends \phpGone\Core\BackController
{
    protected $mainView;

    public function setUp()
    {
        $this->mainView = 'Show/index.twig';
    }

    public function index()
    {
        Renderer::twigRender($this->mainView, []);
    }

    public function doc()
    {
        Renderer::twigRender('Show/index.twig', [], true);
        Renderer::render('Show/doc', []);
    }
}
