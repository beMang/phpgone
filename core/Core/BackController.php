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

    /**
     * Rendu principal du controller
     *
     * @var \phpGone\Core\Renderer\RendererInterface
     */
    protected $mainRender = null;

    /**
     * Vue associée au controller
     *
     * @var string
     */
    protected $view = '';

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

        $renderClassName = '\phpGone\Renderer\\' . $app->getConfig()->get("defaultMainRender") . 'Renderer';
        $this->setMainRender(new $renderClassName($this->getApp()));
        
        $this->setModule($module);
        $this->setAction($action);
        $this->setView($action);
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
     * Récupère le rendu principal
     *
     * @return \phpGone\Core\Renderer\RendererInterface
     */
    public function getMainRender()
    {
        return $this->mainRender;
    }

    /**
     * Modifie le rendu principal
     *
     * @param \phpGone\Renderer\RendererInterface $render Rendu à définir
     * @return void
     */
    public function setMainRender(\phpGone\Renderer\RendererInterface $render)
    {
        $this->mainRender = $render;
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
     * Défini la vue correspondante au module et à l'action
     *
     * @param string $view
     * @return \InvalidArgumentException Si erreur
     */
    public function setView($view)
    {
        if (!is_string($view) || empty($view)) {
            throw new \InvalidArgumentException('La vue doit être une chaine de caractères valides');
        }
        $this->view = $view;

        if ($this->getApp()->getConfig()->get("defaultMainRender") == 'Twig') {
            $extension = '.twig';
        } else {
            $extension = '.php';
        }
        $this->getMainRender()->setContentFile(
            '/' . $this->module . '/' . $this->view . $extension
        );
    }
}
