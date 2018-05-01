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
class BackController extends ApplicationComponent
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
    public function __construct(Application $app, $action)
    {
        parent::__construct($app);
        
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
        $this->$method($this->app->getRequest());
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

    /**
     * Renvoie une instance de \phpGone\Renderer\Renderer
     *
     * @return \phpGone\Renderer\Renderer
     */
    public function getRenderer()
    {
        if (is_null($this->renderer)) {
            $this->setRenderer(new \phpGone\Renderer\Renderer($this->getApp()));
            return $this->renderer;
        } else {
            return $this->renderer;
        }
    }

    /**
     * Défini l'attribut renderer
     *
     * @param \phpGone\Renderer\Renderer $renderer
     * @return void
     */
    private function setRenderer(\phpGone\Renderer\Renderer $renderer)
    {
        $this->renderer = $renderer;
    }
}
