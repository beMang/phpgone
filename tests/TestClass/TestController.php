<?php

namespace tests\TestClass;

use GuzzleHttp\Psr7\Response;

class TestController extends \phpGone\Core\BackController
{
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

    public function error404()
    {
        return new Response('404', [], 'Error 404');
    }
}
