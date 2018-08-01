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

use bemang\Config;
use Psr\Log\LogLevel;
use phpGone\Log\Logger;
use phpGone\Router\Route;
use GuzzleHttp\Psr7\Response;
use phpGone\Core\BackController;
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

    protected function getController(ServerRequestInterface $request): BackController
    {
        $errorPageConfig = Config::getInstance()->get('errorPage');
        $controllerClass = '\\app\\Controllers\\' . $errorPageConfig[0];
        $route = new Route('404', $errorPageConfig[0], $errorPageConfig[1]);
        return new $controllerClass($route, $request);
    }
}
