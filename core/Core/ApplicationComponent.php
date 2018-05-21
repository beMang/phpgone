<?php
/**
 * Fichier de la classe ApplicationComponent
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Core;

/**
 * Class ApplicationComponent
 */
class ApplicationComponent
{
    /**
     * Application du composant
     *
     * @var \phpGone\Core\Application
     */
    protected $app;

    /**
     * Constructeur d'un composant
     *
     * @param Application $app Application du nouveau composant
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Renvoie l'application du composant
     *
     * @return \phpGone\Core\Application
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Renvoie la classe de configuration de l'application
     *
     * @return \phpGone\Core\Config
     */
    public function getConfig()
    {
        return \bemang\Config::getInstance();
    }
}
