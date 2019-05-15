<?php

namespace app\Controllers\Error;

use bemang\Config;
use phpGone\Helpers\Url;
use Psr\Log\LoggerInterface;
use GuzzleHttp\Psr7\Response;
use bemang\renderer\TwigRender;

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
