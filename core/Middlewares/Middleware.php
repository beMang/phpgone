<?php
/**
 * Fichier de la classe abstraite Middleware
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Middlewares;

/**
 * Abstract class Middleware
 * Classe de base pour un middleware, permet d'accéder à l'application
 */
abstract class Middleware extends \phpGone\Core\ApplicationComponent
{
    /**
     * Annule le constructeur
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
    }

    /**
     * Fonction pour faire fonctionner le middleware
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Requête à traiter
     * @param callable $next Prochain middleware à traiter
     * @return mixed
     */
    abstract public function __invoke(\Psr\Http\Message\ServerRequestInterface $request, $next);
}
