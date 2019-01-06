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
        $url = new Url();
        $render = new TwigRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
        $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
        return new Response('404', [], $render->render('Error/404.twig', []));
    }
}
