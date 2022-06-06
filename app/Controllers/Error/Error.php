<?php

namespace app\Controllers\Error;

use phpGone\Core\BackController;
use phpGone\Router\Route;
use Psr\Log\LoggerInterface;

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends BackController
{
    #[Route('', 'Error\Error', 'error404')]
    public function error404(LoggerInterface $logger)
    {
        $logger->error('Error 404');
        return $this->render('Error/404.twig', []);
    }
}
