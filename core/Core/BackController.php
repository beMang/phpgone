<?php

namespace phpGone\Core;

use phpGone\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BackController
 * Class abstraite de base pour les controleurs
 */
abstract class BackController
{
    private $route;
    private $request;

    /**
     * Constucteur du BackController
     *
     * @param Route $route Route qui a 'matché'
     * @param ServerRequestInterface $request Requête à traiter
     */
    public function __construct(Route $route, $request)
    {
        $this->setRoute($route);
        $this->setRequest($request);
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action 
     * et fourni les bons arguments
     *
     * @return void
     */
    public function execute()
    {
        if (method_exists($this, 'setUp')) {
            call_user_func_array([$this, 'setUp'], [$this->request]);
        }
        call_user_func_array(
            [$this, $this->getRoute()->getAction()], 
            $this->provideParameters($this->getRoute()->getAction())
        );
    }

    private function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    private function setRoute(Route $route)
    {
        $this->route = $route;
    }

    protected function getRoute() :Route
    {
        return $this->route;
    }

    protected function getActionParameters(string $action) 
    {
        $method = new \ReflectionMethod(get_class($this), $action);
        return $method->getParameters();
    }

    protected function provideParameters(string $action) :array
    {
        if (method_exists($this, $action)) {
            $resultArray = [];
            $parameters = $this->getActionParameters($action);
            foreach ($parameters as $reflectionParameter) {
                $resultArray[] = $this->provideParameter($reflectionParameter);
            }
            return $resultArray;
        } else {
            throw new \InvalidArgumentException("La méthode $action n'existe pas");
        }
    }

    /**
     * Fourni le bon argument
     *
     * @param \ReflectionParameter $param
     * @return mixin argument à utiliser
     */
    protected function provideParameter(\ReflectionParameter $reflectionParameter)
    {
        if ($reflectionParameter->getType() == 'string' || $reflectionParameter->getType() == '') {
            if (array_key_exists($reflectionParameter->getName(), $this->getRoute()->getMatches())) {
                return $this->getRoute()->getMatches()[$reflectionParameter->getName()];
            }
        }
        if ($reflectionParameter->getType() == 'Psr\Log\LoggerInterface') {
            return new \phpGone\Log\Logger();
        }
        if ($reflectionParameter->getType() == 'GuzzleHttp\Psr7\Request') {
            return $this->request;
        }
        if ($reflectionParameter->getType() == 'phpGone\Helpers\Url') {
            return new \phpGone\Helpers\Url();
        }
        // Renderer (TODO with new render system)
        // Helpers (core)
    }
}
