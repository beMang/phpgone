<?php
namespace app\Controllers\Show;

use phpGone\Renderer\Renderer;

class Show extends \phpGone\Core\BackController
{
    public function executeIndex(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $this->getRenderer()->twigRender('Show/index.twig', []);
    }
}
