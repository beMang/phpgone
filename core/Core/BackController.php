<?php
/**
 * Fichier de la classe BackController
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Core;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class BackController
 * Class abstraite de base pour les controleurs des modules
 */
class BackController
{
    /**
     * Action du controller
     *
     * @var string
     */
    protected $action;

    private $request;

    /**
     * Constucteur du BackController
     *
     * @param Application $app Application du composant BackController
     * @param string $module Module du controller
     * @param string $action Action à executer sur le controller
     */
    public function __construct(string $action, $request)
    {
        $this->setAction($action);
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

    /**
     * Défini l'action à executer
     *
     * @param string $action Action à executer
     */
    public function setAction(string $action)
    {
        $this->action = $action;
    }
}
