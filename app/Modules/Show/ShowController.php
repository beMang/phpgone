<?php
namespace app\Modules\Show;

use phpGone\Renderer\Renderer;

class ShowController extends \phpGone\Core\BackController
{
    public function executeIndex(\Psr\Http\Message\ServerRequestInterface $request)
    {
        Renderer::twigRender('Show/index.twig', []);
    }
}
