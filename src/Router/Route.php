<?php

namespace phpGone\Router;

use Attribute;
use bemang\Config;
use InvalidArgumentException;

/**
 * Class Route
 *
 * Représente une route
 */
#[Attribute]
class Route
{
    protected string $action;
    protected string $pathController;
    protected string $url;
    protected array $matches = ['completePath' => null];
    protected string $expression = '([{][a-z]*[|]?[}])';
    protected array $patterns = [
        '`[{][a-z]*[}]`' => '(.*)',
        '`[{][a-z]*[|]{1}[}]`' => '([0-9]*)'
    ];

    /**
     * Constructeur class route
     *
     * @param string $url Url de la route
     * @param string $controller Controlleur à appeler
     * @param string $method Method du controlleur à appeler
     */
    public function __construct(string $url, string $controller, string $method)
    {
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($method);
    }

    protected function setController(string $controller)
    {
        if (class_exists($controller)) {
            $this->pathController = $controller;
        } elseif (class_exists(Config::getInstance()->get('controllersNamespace') . $controller)) {
            $this->pathController = Config::getInstance()->get('controllersNamespace') . $controller;
        } else {
            throw new InvalidArgumentException('La classe du controller ' .
                $controller . ' est inexistante (Voir fichier de config)');
        }
    }

    public function match(string $url): bool
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            $this->setMatches($matches);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Récupère l'action de la route
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    protected function setAction(string $action): void
    {
        if (method_exists($this->getController(), $action)) {
            $this->action = $action;
        } else {
            throw new InvalidArgumentException(
                'L\'action de la route est inaccesible ou inconnue (Voir fichier de config)'
            );
        }
    }

    /**
     * Récupère le contrôleur de la route
     *
     * @return string
     */
    public function getController(): string
    {
        return $this->pathController;
    }

    /**
     * Récupère l'url de la route (transformé)
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    protected function setUrl(string $url): void
    {
        preg_match_all($this->expression, $url, $matches);
        foreach ($matches[0] as $key => $value) {
            preg_match('`^[{]([a-z]*)[|]?[}]$`', $value, $matchName);
            $this->matches[$matchName[1]] = null;
        }
        $finalUrl = $url;
        foreach ($this->patterns as $key => $value) {
            $finalUrl = preg_replace($key, $value, $finalUrl);
        }
        $this->url = $finalUrl;
    }

    /**
     * Renvoie les matches (url correcte)
     *
     * @return array
     */
    public function getMatches(): array
    {
        return $this->matches;
    }

    protected function setMatches($matches): void
    {
        if (is_array($matches)) {
            if (count($this->matches) === count($matches)) {
                $keys = array_keys($this->matches);
                for ($i = 0; $i < count($this->matches); $i++) {
                    $this->matches[$keys[$i]] = $matches[$i];
                }
            } else {
                // Je sais pas trop à quel cas ça correspond
            }
        }
    }
}
