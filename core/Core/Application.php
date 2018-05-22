<?php

/**
 * Fichier de la classe Application
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Core;

/**
 * class Application
 *
 * Permet d'utiliser les autres classes, c'est le centre de la lib.
 * @package adriRoot
 */
class Application
{
    /**
     * Contient la classe du fichier de configuration
     *
     * @var string
     */
    protected $config;

    /**
     * Contient la requête
     *
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $httpRequest;

    /**
     * Contient la réponse générée par l'application
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $httpResponse;

    /**
     * Contient le gestionnaire de middlewares
     *
     * @var \phpGone\Core\MiddlewaresDispatcher
     */
    protected $middlewaresDispatcher;

    /**
     * Constructeur de la classe
     *
     * @param string $config Fichier de configuration de l'application
     * @param \Psr\Http\Message\ServerRequestInterface $request Requete à traiter
     */
    public function __construct($configFile, \Psr\Http\Message\ServerRequestInterface $request)
    {
        $config = \bemang\Config::getInstance();
        $config->define(require($configFile));
        $this->httpRequest = $request;
        $this->middlewaresDispatcher = new MiddlewaresDispatcher();
    }

    /**
     * Récupère une réponse en fonction de la requête
     *
     * @return \Psr\Http\Message\ResponseInterface Réponse renvoyée
     */
    public function run()
    {
        return $this->setHttpResponse($this->middlewaresDispatcher->process($this->httpRequest));
    }

    public function send()
    {
        $responseSender = new \phpGone\Core\ResponseSender();
        return $responseSender->send($this->httpResponse);
    }

    public function setHttpResponse(\Psr\Http\Message\ResponseInterface $response)
    {
        $this->httpResponse = $response;
        return $response;
    }

    public function getRequest()
    {
        return $this->httpRequest;
    }

    /**
     * Ajoute un middleware à l'application (Au début du tableau)
     *
     * @param string $middleware Nom du middleware à utiliser
     * @return \phpGone\Core\Application Application (Pour enchainer les méthodes pipe)
     */
    public function addMiddlewares($middleware)
    {
        $this->middlewaresDispatcher->pipe($middleware);
        return $this;
    }
}
