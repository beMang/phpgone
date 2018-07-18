<?php

namespace app\Controllers\Error;

<<<<<<< develop
use Psr\Log\LoggerInterface;
use phpGone\Renderer\Renderer;
=======
use bemang\Config;
use phpGone\Helpers\Url;
use bemang\renderer\TwigRender;
>>>>>>> first integration of renderer system

/**
 * Controller pour la gestion des erreurs 404
 */
class Error extends \phpGone\Core\BackController
{
    public function index(LoggerInterface $logger)
    {
<<<<<<< develop
        Renderer::twigRender('Demo/index.twig', [], true);
        Renderer::twigRender('Error/404.twig', []);
        $logger->info('Error 404, NotFoundMiddleware');
=======
        $url = new Url();
        $render = new TwigRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
        $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
        echo $render->render('Error/404.twig', []);
>>>>>>> first integration of renderer system
    }
}
