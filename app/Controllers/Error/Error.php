<?php

namespace app\Controllers\Error;

use bemang\Config;
use phpGone\Helpers\Url;
use Psr\Log\LoggerInterface;
use bemang\renderer\TwigRender;

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends \phpGone\Core\BackController
{
    public function index(LoggerInterface $logger)
    {
        $url = new Url();
        $render = new TwigRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
        $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
        echo $render->render('Error/404.twig', []);
    }
}
