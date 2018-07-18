<?php

namespace phpGone\Router;

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

    public function __construct($url, $controller, $method)
    {
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($method);
    }

    public function match($url) :bool
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            $this->setMatches($matches);
            return true;
        } else {
            return false;
        }
    }

    protected function setAction($action)
    {
        if (is_callable([$this->getController(), $action])) {
            $this->action = $action;
        } else {
            throw new \InvalidArgumentException('L\'action de la route est inaccesible ou inconnue (Voir fichier de config)');
        }
    }

    protected function setController($controller)
    {
        if (class_exists('\\app\\Controllers\\' . $controller)) {
            $this->controller = '\\app\\Controllers\\' . $controller;
        } else {
            throw new \InvalidArgumentException('La classe du controller \\app\\Controllers\\' .
            $controller . 'est inexistante (Voir fichier de config)');
        }
    }

    protected function setUrl($url)
    {
        if (is_string($url)) {
            preg_match_all($this->expression, $url, $matches);
            foreach ($matches[0] as $key => $value) {
                preg_match('`^[{]([a-z]*)[|]?[}]$`', $value, $matchName);
                $this->matches[$matchName[1]] = null;
            }
            //TODO : better system for pattern (more dynamic)
            $finalUrl = preg_replace('`[{][a-z]*[}]`', $this->patterns['all'], $url);
            $finalUrl = preg_replace('`[{][a-z]*[|]{1}[}]`', $this->patterns['int'], $finalUrl);
            $this->url = $finalUrl;
        } else {
            throw new \InvalidArgumentException('L\'url de la route est invalide (Voir fichier de config)');
        }
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getUrl()
    {
        return $this->url;
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

    public function getMatches()
    {
        return $this->matches;
    }
}
