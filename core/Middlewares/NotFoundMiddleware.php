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
     * Process method for NotFoundMiddleware
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface Réponse 404
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $errorPageConfig = Config::getInstance()->get('errorPage');
        $controllerClass = '\\app\\Controllers\\' . $errorPageConfig[0];
        $controller = new $controllerClass($errorPageConfig[1], $request);
        $response = new Response;
        ob_start();
        $controller->execute();
        $responseController = ob_get_clean();
        $response->getBody()->write($responseController);
        $response = $response->withStatus(404);
        Logger::doLog(LogLevel::INFO, 'Error 404, NotFoundMiddleware');
        return $response;
    }
}
