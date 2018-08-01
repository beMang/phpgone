<?php

namespace phpGone\Middlewares;

use bemang\Config;
use phpGone\Core\BackController;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

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
            new \phpGone\Router\Routeur(),
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
     * @param \phpGone\Router\Routeur $router Routeur à utiliser
     * @return void
     */
    public function getController($router, $request)
    {
        $routes = Config::getInstance()->get('routes');
        
        foreach ($routes as $route) {
            $router->addRoute($route);
            unset($route);
        }

        try {
            $matchedRoute = $router->getRoute($request->getUri()->getPath(), true);
        } catch (\RuntimeException $e) {
            if ($e->getCode() == \phpGone\Router\Routeur::NO_ROUTE) {
                return null; //Permet de passer au middleware suivant
            }
        }
        $controllerClass = $matchedRoute->getController();             
        return new $controllerClass($matchedRoute, $request);
    }
}
