<?php

namespace app\Controllers\Error;

use phpGone\Renderer\Renderer;

class Error extends \phpGone\Core\BackController
{
    public function index()
    {
        Renderer::twigRender('Error/404.twig', []);
    }
}
