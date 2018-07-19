<?php

namespace phpGone\Router;

use phpGone\Core\BackController;

/**
 * Class Route
 * 
 * Représente une route
 */
class Route
{
    protected $action;
    protected $controller;
    protected $url;
    protected $matches = ['completePath' => null];
    protected $expression = '([{][a-z]*[|]?[}])';
    protected $patterns = [ 
        'all' => '(.*)', 
        'int' => '([0-9]*)'
    ]; 

    /**
     * Constructeur class route
     *
     * @param string $url Url de la route
     * @param BackController $controller Controlleur à appeler
     * @param string $method Method du controlleur à appeler
     */
    public function __construct(string $url, BackController $controller, string $method)
    {
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($method);
    }

    public function match(string $url) :bool
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            $this->setMatches($matches);
            return true;
        } else {
            return false;
        }
    }

    protected function setAction(string $action)
    {
        if (is_callable([$this->getController(), $action])) {
            $this->action = $action;
        } else {
            throw new \InvalidArgumentException('L\'action de la route est inaccesible ou inconnue (Voir fichier de config)');
        }
    }

    protected function setController(BackController $controller)
    {
        if (class_exists('\\app\\Controllers\\' . $controller)) {
            $this->controller = '\\app\\Controllers\\' . $controller;
        } else {
            throw new \InvalidArgumentException('La classe du controller \\app\\Controllers\\' .
            $controller . 'est inexistante (Voir fichier de config)');
        }
    }

    protected function setUrl(string $url)
    {
        preg_match_all($this->expression, $url, $matches);
        foreach ($matches[0] as $key => $value) {
            preg_match('`^[{]([a-z]*)[|]?[}]$`', $value, $matchName);
            $this->matches[$matchName[1]] = null;
        }
        //TODO : better system for pattern (more dynamic)
        $finalUrl = preg_replace('`[{][a-z]*[}]`', $this->patterns['all'], $url);
        $finalUrl = preg_replace('`[{][a-z]*[|]{1}[}]`', $this->patterns['int'], $finalUrl);
        $this->url = $finalUrl;
    }

    protected function setMatches($matches)
    {
        if (is_array($matches)) {
            if (count($this->matches) === count($matches)) {
                $keys = array_keys($this->matches);
                for ($i=0; $i < count($this->matches); $i++) { 
                    $this->matches[$keys[$i]] = $matches[$i];
                }
            } else {
                
            }
        }
    }

    /**
     * Récupère l'action de la route
     *
     * @return string
     */
    public function getAction() :string
    {
        return $this->action;
    }

    /**
     * Récupère le controlleur de la route
     *
     * @return BackController
     */
    public function getController() :BackController
    {
        return $this->controller;
    }

    /**
     * Récupère l'url de la route (transformé)
     *
     * @return string
     */
    public function getUrl() :string
    {
        return $this->url;
    }

    /**
     * Renvoie les matches (url correcte)
     *
     * @return array
     */
    public function getMatches() :array
    {
        return $this->matches;
    }
}
