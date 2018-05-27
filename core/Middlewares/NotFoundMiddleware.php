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

use Psr\Log\LogLevel;
use phpGone\Log\Logger;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class NotFoundMiddleware
 * Permet de gérer une requête 404
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * Fait fonctionner le middleware (Méthode magique)
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Requête à traiter
     * @param string $next Fonction à appeler
     * @return \Psr\Http\Message\Response
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = new \phpGone\Error\ErrorController('show');
        $response = new Response;
        $response = $response->withStatus(404);
        ob_start();
        $controller->execute();
        $responseController = ob_get_clean();
        $response->getBody()->write($responseController);
        Logger::doLog(LogLevel::INFO, 'Error 404, NotFoundMiddleware');
        //$this->getApp()->getContainer()->get(\phpGone\Log\Logger::class)->info('Not Found 404'); //Log
        return $response;
    }
}
