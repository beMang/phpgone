<?php

namespace app\Controllers\Demo;

use bemang\Config;
use phpGone\Helpers\Url;
use bemang\renderer\PHPRender;
use bemang\renderer\TwigRender;

/**
 * Controller basique
 */
class Show extends \phpGone\Core\BackController
{
    protected $mainView;

    public function setUp()
    {
        $this->mainView = 'Demo/index.twig';
    }

    public function index()
    {
        $url = new Url();
        $render = new TwigRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
        $render->addTwigExtensions(Config::getInstance()->get('TwigExtensions'));
        echo $render->render($this->mainView, []);
    }

    public function doc()
    {
        $url = new Url();
        $render = new PHPRender($url->getAppPath('views'), $url->getTmpPath('cache/twig'));
        echo $render->render('Demo/doc', []);
    }
}
