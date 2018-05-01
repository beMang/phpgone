<?php
/**
 * Fichier de la classe CoreMiddleware
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Middlewares;

/**
 * Class CoreMiddleware
 * Middleware qui execute les controleurs des modules
 */
class CoreMiddleware extends Middleware
{
    public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, $next)
    {
        $response = new \GuzzleHttp\Psr7\Response();
        $controller = $this->getController(
            new \phpGone\Router\Routeur(),
            $request
        );
        if (is_null($controller)) {
            return $next($request);
        }
        ob_start();
        $controller->execute();
        $responseController = ob_get_clean();
        $response->getBody()->write($responseController);
        //$this->getApp()->getContainer()->get(\phpGone\Log\Logger::class)
        //                               ->info('Requête traitée par le core(Middleware)');
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
        $xml = new \DOMDocument;
        $routes = $this->getConfig()->get('routes');
        
        foreach ($routes as $route) {
            $router->addRoute($route);
            unset($route);
        }

        try {
            $matchedRoute = $router->getRoute($request->getUri()->getPath());
        } catch (\RuntimeException $e) {
            if ($e->getCode() == \phpGone\Router\Routeur::NO_ROUTE) {
                return null; //Permet de traiter la requête NotFound (Middleware)
            }
        }

        $_GET = array_merge($_GET, $matchedRoute->getMatches());

        $controllerClass = $matchedRoute->getController();
                            
        return new $controllerClass($this->getApp(), $matchedRoute->getAction());
    }
}
