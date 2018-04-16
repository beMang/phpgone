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

    /**
     * Module du controller
     *
     * @var string
     */
    protected $module = '';

    protected $renderer = null;

    /**
     * Constucteur du BackController
     *
     * @param Application $app Application du composant BackController
     * @param string $module Module du controller
     * @param string $action Action à executer sur le controller
     */
    public function __construct(Application $app, $module, $action)
    {
        parent::__construct($app);
        
        $this->setModule($module);
        $this->setAction($action);
    }

    /**
     * Execute la bonne fonction enfante en fonction de l'action
     *
     * @return void
     */
    public function execute()
    {
        $method = 'execute' .ucfirst($this->action);

        if (!is_callable([$this, $method])) {
            throw new \RuntimeException('L\'action' . $this->action . 'n\'est pas définie sur ce module');
        }
        $this->$method($this->app->getRequest());
    }

    /**
     * Défini le module du controller
     *
     * @param string $module Module à définir
     * @return \InvalidArgumentException Si erreur
     */
    public function setModule($module)
    {
        if (!is_string($module) || empty($module)) {
            throw new \InvalidArgumentException('Le module doit être une chaine de caractères valide');
        }
        $this->module = $module;
    }

    /**
     * Défini l'action à executer
     *
     * @param string $action Action à executer
     * @return \InvalidArgumentException Si erreur
     */
    public function setAction($action)
    {
        if (!is_string($action) || empty($action)) {
            throw new \InvalidArgumentException('L\'action doit être une chaine de caractères valide');
        }
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
