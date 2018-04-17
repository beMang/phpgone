<?php
/**
 * Fichier de la classe NotFoundMiddleware
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Middlewares;

use GuzzleHttp\Psr7\Response;

/**
 * Class NotFoundMiddleware
 * Permet de gérer une requête 404
 */
class NotFoundMiddleware extends Middleware
{
    /**
     * Fait fonctionner le middleware (Méthode magique)
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Requête à traiter
     * @param string $next Fonction à appeler
     * @return \Psr\Http\Message\Response
     */
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, $next)
    {
        $controller = new \phpGone\Error\ErrorController($this->getApp(), 'Error', 'show');
        $controller->execute();
        $response = new Response;
        $response = $response->withStatus(404);
        $response->getBody()->write('Error 404');
        //$this->getApp()->getContainer()->get(\phpGone\Log\Logger::class)->info('Not Found 404'); //Log
        return $response;
    }
}
