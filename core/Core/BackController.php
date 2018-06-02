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
    private $action;
    private $request;

    /**
     * Constucteur du BackController
     *
     * @param string $module Action à appeler
     * @param ServerRequestInterface $request Requête à traiter
     */
    public function __construct(Route $route, $request)
    {
        $this->setAction($route->getAction());
        $this->setRequest($request);
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action
     *
     * @return void
     */
    public function execute()
    {
        if (method_exists($this, 'setUp')) {
            call_user_func_array([$this, 'setUp'], [$this->request]);
        }
        call_user_func_array([$this, $this->action], [$this->request]);
    }

    private function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    private function setAction(string $action)
    {
        $this->action = $action;
    }
}
