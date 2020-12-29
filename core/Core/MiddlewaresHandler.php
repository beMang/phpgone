<?php

namespace phpGone\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * class MiddlewaresHandler
 *
 * Gestionnaire de middlewares du framework
 */
class MiddlewaresHandler implements RequestHandlerInterface
{
    /**
     * Contient middlewares
     *
     * @var string[]
     */
    protected $middlewares = [
        \phpGone\Middlewares\CoreMiddleware::class,
        \phpGone\Middlewares\NotFoundMiddleware::class
    ];

    /**
     * Index du middleware suivant
     *
     * @var int
     */
    protected int $middlewaresIndex = 0;

    /**
     * Ajoute un middleware à l'application (Au début du tableau)
     *
     * @param string|MiddlewareInterface $middleware Middleware à ajouter
     * @return bool
     */
    public function pipe($middleware) :bool
    {
        array_unshift($this->middlewares, $middleware);
        return true;
    }

    /**
     * Parcours les middlwares et les execute
     *
     * @param ServerRequestInterface $request Requête à envoyer aux middlewares
     * @return ResponseInterface Réponse obtenue
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->getMiddleware();
        if (is_null($middleware)) {
            throw new \RuntimeException('Un middleware est mal configuré ou aucun middleware défini');
        }
        return call_user_func_array([$middleware, 'process'], [$request, $this]);
    }

    /**
     * Récupère le prochain middleware à utiliser
     *
     * @return MiddlewareInterface|null Middleware ou null si pas de middleware
     */
    private function getMiddleware() :?MiddlewareInterface
    {
        if (array_key_exists($this->middlewaresIndex, $this->middlewares)) {
            $middleware = $this->middlewares[$this->middlewaresIndex];
            if (is_object($middleware) &&
                $middleware instanceof MiddlewareInterface
            ) {
                $this->middlewaresIndex++;
                return $middleware;
            } else {
                if (class_exists($middleware)) {
                    $reflexionClass = new \ReflectionClass($middleware);
                    if ($reflexionClass->implementsInterface(MiddlewareInterface::class)) {
                        $resultMiddleware = new $middleware();
                        $this->middlewaresIndex++;
                        return $resultMiddleware;
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            }
        }
        return null;
    }

    /**
     * Reset les middlewares
     *
     * @return bool
     */
    public function resetMiddlewares() :bool
    {
        $this->middlewares = [];
        return true;
    }
}
