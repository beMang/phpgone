<?php

namespace phpGone\Middlewares;

use phpGone\Core\BackController;
use phpGone\Router\Routeur;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use RuntimeException;

/**
 * Class CoreMiddleware
 * Middleware principal qui execute la bonne méthode en fonction de la requête
 */
class CoreMiddleware implements MiddlewareInterface
{
    /**
     * Méthode principale
     *
     * @param ServerRequestInterface $request Requête à traiter
     * @param RequestHandlerInterface $handler Gestionnaire de middleware
     * @return ResponseInterface Réponse
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $controller = $this->getController(
            new Routeur(),
            $request
        );
        if (is_null($controller)) {
            return $handler->handle($request);
        }
        $response = $controller->execute();
        return $response;
    }

    /**
     * Récupère le controlleur correspondant à la requête
     *
     * @param Routeur $router Routeur à utiliser
     * @return BackController
     */
    public function getController($router, $request)
    {
        try {
            $matchedRoute = $router->getMatchedRoute($request->getUri()->getPath());
        } catch (RuntimeException $e) {
            if ($e->getCode() == Routeur::NO_ROUTE) {
                return null; //Permet de passer au middleware suivant
            }
        }
        $controllerClass = $matchedRoute->getController();
        return new $controllerClass($matchedRoute, $request);
    }
}
