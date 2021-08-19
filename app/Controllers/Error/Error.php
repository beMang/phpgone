<?php

namespace app\Controllers\Error;

use Psr\Log\LoggerInterface;

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends \phpGone\Core\BackController
{
    public function index(LoggerInterface $logger)
    {
        $logger->error('Error 404');
        return $this->render('Error/404.twig', []);
    }
}
