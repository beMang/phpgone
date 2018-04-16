<?php
/**
 * Fichier de la classe MiddlewaresDispatcher
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Core;

/**
 * class MiddlewaresDispatcher
 *
 * Gère les middlewares et les execute
 * @package adriRoot
 */
class MiddlewaresDispatcher extends ApplicationComponent
{
    /**
     * Contient les différents middlewares à utiliser
     *
     * @var string[]
     */
    protected $middlewares = ['CoreMiddleware', 'NotFoundMiddleware'];

    /**
     * Index à utiliser pour parcourir les middlwares
     *
     * @var int
     */
    protected $middlewaresIndex = 0;

    /**
     * Ajoute un middleware à l'application (Au début du tableau)
     *
     * @param string $middleware Nom du middleware à utiliser
     * @return void
     */
    public function pipe($middleware)
    {
        array_unshift($this->middlewares, $middleware);
    }

    /**
     * Parcours les middlwares et les execute
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Requête à envoyer au middlware
     * @return callable/bool Fonction à appeler ou false si erreur
     */
    public function process(\Psr\Http\Message\ServerRequestInterface $request)
    {
        $middleware = $this->getMiddleware();
        if (is_null($middleware)) {
            return false;
        }
        return call_user_func_array($middleware, [$request, [$this, 'process']]);
    }

    /**
     * Récupère le prochain middleware à utiliser
     *
     * @return \phpGone\Middlewares\MiddlewareInterface/null Middleware ou null si pas de middleware
     */
    private function getMiddleware()
    {
        if (array_key_exists($this->middlewaresIndex, $this->middlewares)) {
            $middleWareClass = '\\phpGone\Middlewares\\' . $this->middlewares[$this->middlewaresIndex]; 
            $middleware = new $middleWareClass($this->getApp());
            $this->middlewaresIndex++;
            return $middleware;
        }
        return null;
    }
}