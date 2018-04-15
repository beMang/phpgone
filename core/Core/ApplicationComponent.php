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
 * Abstraite, faite pour les composants de l'application
 */
abstract class ApplicationComponent
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

    public function setApp(\phpGone\Core\Application $app)
    {
        $this->app = $app;
    }
}
