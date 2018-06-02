<?php

namespace app\Controllers\Error;

use phpGone\Renderer\Renderer;

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends \phpGone\Core\BackController
{
    public function index()
    {
        Renderer::twigRender('Demo/index.twig', [], true);
        Renderer::twigRender('Error/404.twig', []);
    }
}
