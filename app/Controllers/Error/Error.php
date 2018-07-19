<?php

namespace app\Controllers\Error;

use Psr\Log\LoggerInterface;
use phpGone\Renderer\Renderer;

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends \phpGone\Core\BackController
{
    public function index(LoggerInterface $logger)
    {
        Renderer::twigRender('Demo/index.twig', [], true);
        Renderer::twigRender('Error/404.twig', []);
        $logger->info('Error 404, NotFoundMiddleware');
    }
}
