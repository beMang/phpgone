<?php

namespace app\Controllers\Demo;

use GuzzleHttp\Psr7\Response;
use phpGone\Core\BackController;
use phpGone\Router\Route;

/**
 * Controller basique
 */
class Show extends BackController
{
    protected $mainView;

    public function setUp()
    {
        $this->mainView = 'Demo/index.twig';
    }

    #[Route('/', 'Demo\Show', 'index')]
    public function index()
    {
        return $this->render($this->mainView, []);
    }

    #[Route('/doc', 'Demo\Show', 'doc')]
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
    #[Route('/{num|}', 'Demo\Show', 'demonum')]
    public function demonum($num)
    {
        return new Response('200', [], 'ça marche, voici le numéro de l\'url : ' . $num);
    }
}
