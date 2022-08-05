<?php

namespace phpGone\Middlewares;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
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
                $response = new Response();
                $response = $response->withStatus(301)
                    ->withHeader('Location', substr($uri, 0, -1));
                return $response;
            }
        }
        return $handler->handle($request);
    }
}
