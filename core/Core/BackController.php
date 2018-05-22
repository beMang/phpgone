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
    protected $action = '';

    protected $renderer = null;

    /**
     * Constucteur du BackController
     *
     * @param Application $app Application du composant BackController
     * @param string $module Module du controller
     * @param string $action Action à executer sur le controller
     */
    public function __construct($action)
    {
        $this->setAction($action);
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action
     *
     * @return void
     */
    public function execute()
    {
        $method = $this->action;
        $this->$method();
    }

    /**
     * Défini l'action à executer
     *
     * @param string $action Action à executer
     */
    public function setAction($action)
    {
        $this->action = $action;
    }
}
