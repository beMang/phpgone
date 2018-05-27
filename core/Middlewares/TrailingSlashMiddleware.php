<?php
/**
 * Fichier de la classe TrailingSlashMiddleware
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class TrailingSlashMiddleware
 * Permet de rediriger si il y a un slash a la fin de l'url
 */
class TrailingSlashMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (substr($uri, -1, 1) == '/') {
            if (!empty(substr($uri, 0, -1))) {
                $response = new \GuzzleHttp\Psr7\Response;
                $response = $response->withStatus(301)
                                 ->withHeader('Location', substr($uri, 0, -1));
                //$this->getApp()->getContainer()->get(\phpGone\Log\Logger::class)
                //                               ->info('Redirection vers ' . substr($uri, 0, -1));
                return $response;
            }
        }
        return $handler->handle($request);
    }
}
