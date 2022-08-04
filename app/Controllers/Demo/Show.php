<?php

namespace app\Controllers\Demo;

use GuzzleHttp\Psr7\Response;
use phpGone\Core\BackController;
use phpGone\Router\Route;
use Psr\Http\Message\ResponseInterface;

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
    public function doc(): ResponseInterface
    {
        return $this->render('Demo/doc', [], 'php');
    }

    /**
     * Voici un exemple de récupération d'url
     *
     * @param int $num
     * @return Response
     */
    #[Route('/{num|}', 'Demo\Show', 'demonum')]
    public function demonum($num): ResponseInterface
    {
        return new Response('200', [], 'ça marche, voici le numéro de l\'url : ' . $num);
    }
}
