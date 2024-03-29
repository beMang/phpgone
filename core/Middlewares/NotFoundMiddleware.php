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

use phpGone\Core\BackController;
use phpGone\Router\Routeur;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class NotFoundMiddleware
 * Permet de gérer une requête 404
 */
class NotFoundMiddleware implements MiddlewareInterface
{
    /**
     * Process method for NotFoundMiddleware
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface Réponse 404
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = $this->getController($request);
        $response = $controller->execute();
        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @return BackController
     */
    protected function getController(ServerRequestInterface $request): BackController
    {
        $router = new Routeur();
        $errorRoute = $router->getAttributesRoutes()['error404'];
        $controllerName = $errorRoute->getController();
        return new $controllerName($errorRoute, $request);
    }
}
