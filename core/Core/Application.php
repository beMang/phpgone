<?php

namespace phpGone\Core;

use bemang\Config;
use phpGone\Core\ResponseSender;
use phpGone\Core\MiddlewaresHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * class Application
 * Représente l'application
 */
class Application
{
    /**
     * Contient la requête
     *
     * @var ServerRequestInterface
     */
    protected ServerRequestInterface $httpRequest;

    /**
     * Contient la réponse générée par l'application
     *
     * @var ResponseInterface
     */
    protected ResponseInterface $httpResponse;

    /**
     * Contient le gestionnaire de middlewares
     *
     * @var MiddlewaresHandler
     */
    protected MiddlewaresHandler $middlewaresHandler;

    /**
     * Constructeur de la classe
     *
     * @param string $config Fichier de base pour configuration de l'application
     * @param ServerRequestInterface $request Requete à traiter
     */
    public function __construct($configFile, ServerRequestInterface $request)
    {
        $config = Config::getInstance();
        $config->define(require($configFile));
        $this->httpRequest = $request;
        $this->middlewaresHandler = new MiddlewaresHandler();
    }

    /**
     * Génère la réponse en fonction de la requête
     *
     * @return ResponseInterface Réponse générée
     */
    public function run() :ResponseInterface
    {
        return $this->setHttpResponse($this->middlewaresHandler->handle($this->httpRequest));
    }

    /**
     * Envoie le résultat au client
     *
     * @return bool Résultat de l'envoi
     */
    public function send() :bool
    {
        $responseSender = new ResponseSender();
        return $responseSender->send($this->httpResponse);
    }

    /**
     * Permet de récupérer la requête
     *
     * @return objet Requete
     */
    public function getRequest() :ServerRequestInterface
    {
        return $this->httpRequest;
    }

    /**
     * Ajoute un middleware à l'application (Au début du tableau)
     *
     * @param string $middleware Middleware à utiliser
     * @return Application Application (Pour enchainer les méthodes pipe)
     */
    public function addMiddleware($middleware) :self
    {
        $this->middlewaresHandler->pipe($middleware);
        return $this;
    }

    private function setHttpResponse(ResponseInterface $response) :ResponseInterface
    {
        $this->httpResponse = $response;
        return $response;
    }
}
