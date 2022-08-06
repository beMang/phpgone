<?php

namespace phpGone\Core;

use bemang\Config;
use phpGone\Helpers\Url;
use bemang\ConfigException;
use Psr\Http\Message\ResponseInterface;
use bemang\InvalidArgumentExceptionConfig;
use InvalidArgumentException;
use phpGone\Helpers\File;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

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
     * @param string $configFile Fichier de base pour configuration de l'application
     * @param ServerRequestInterface $request Requête à traiter
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function __construct(Config $config, ServerRequestInterface $request)
    {
        $this->checkConfig($config);
        $this->httpRequest = $request;
        $this->middlewaresHandler = new MiddlewaresHandler();
    }

    /**
     * Génère la réponse en fonction de la requête
     *
     * @return ResponseInterface Réponse générée
     */
    public function run(): ResponseInterface
    {
        return $this->setHttpResponse($this->middlewaresHandler->handle($this->httpRequest));
    }

    private function setHttpResponse(ResponseInterface $response): ResponseInterface
    {
        $this->httpResponse = $response;
        return $response;
    }

    /**
     * Envoie le résultat au client
     *
     * @return bool Résultat de l'envoi
     */
    public function send(): bool
    {
        $responseSender = new ResponseSender();
        return $responseSender->send($this->httpResponse);
    }

    /**
     * Permet de récupérer la requête
     *
     * @return ServerRequestInterface Requête
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->httpRequest;
    }

    /**
     * Ajoute un middleware à l'application (Au début du tableau)
     *
     * @param string $middleware Middleware à utiliser
     * @return Application Application (Pour enchainer les méthodes pipe)
     */
    public function addMiddleware(string $middleware): self
    {
        $this->middlewaresHandler->pipe($middleware);
        return $this;
    }

    /**
     * Permet de vérifier la validité des différents chemins de la config
     *
     * @param Config $config
     * @return void
     */
    public function checkConfig(Config $config): void
    {
        $directory_to_check = ['publicPath', 'controllersPath', 'viewsPath', 'tmpPath'];
        foreach ($directory_to_check as $key) {
            if (!$config->has($key)) {
                throw new ConfigException('Configuration incomplète, clé "' . $key . ' manquante.');
            } else {
                if (!is_dir($config->get($key))) {
                    throw new ConfigException('Configuration invalide, la clé ' . $key . 'n\' est pas un dossier valide');
                }
            }
        }
        $url = new Url();
        $this->checkTmpDir($url->getTmpPath());
    }

    /**
     * Permet de vérifier la validité du dossier tmp et le réparer si besoin
     *
     * @param string $tmpDir
     * @return void
     */
    public function checkTmpDir(string $tmpDir): void
    {
        $dirToCheck = ['/log/', '/cache/twig/', 'cache/phpgone/'];
        foreach ($dirToCheck as $dir) {
            if (!is_dir($tmpDir . $dir)) {
                if (!mkdir($tmpDir . $dir, 0777, true)) {
                    throw new RuntimeException('Impossible d\' initialiser le dossier tmp correctement. - ' . $tmpDir . $dir);
                }
            }
        }
    }

    /**
     * Nettoie le dossier tmp
     *
     * @return boolean succès de l'opération
     */
    public function clearTmpDir(): bool
    {
        return ($this->clearLog() && $this->clearCache('both'));
    }

    public function clearLog(): bool
    {
        $url = new Url();
        $logDir = $url->getTmpPath('log');
        return File::clearDirectory($logDir);
    }

    public function clearCache(string $type): bool
    {
        if ($type == 'twig') {
            return $this->clearTWigCache();
        } elseif($type == 'phpgone') {
            return $this->clearPhpgoneCache();
        } elseif($type == 'both') {
            return ($this->clearPhpgoneCache() && $this->clearTWigCache());
        } else {
            throw new InvalidArgumentException('Type inconnu de cache');
        }
    }

    public function clearTWigCache(): bool
    {
        $url = new Url();
        $to_clear = $url->getTmpPath('cache/twig');
        return File::clearDirectory($to_clear);
    }

    public function clearPhpgoneCache(): bool
    {
        $url = new Url();
        $to_clear = $url->getTmpPath('cache/phpgone');
        return File::clearDirectory($to_clear);
    }
}
