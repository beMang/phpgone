<?php

namespace app\Controllers\Demo;

use GuzzleHttp\Psr7\Response;

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
        return $this->render($this->mainView, []);
    }

    public function doc()
    {
        return $this->render('Demo/doc', [], 'php');
    }

    /**
     * Voici un exemple de récupération d'url
     *
     * @param int $num
     * @return void
     */
    public function demonum($num)
    {
        return new Response('200', [], 'ça marche, voici le numéro de l\'url : ' . $num);
    }
}
