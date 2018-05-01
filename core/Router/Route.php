<?php

namespace phpGone\Router;

class Route
{
    protected $action;
    protected $controller;
    protected $url;
    protected $matches = null;
    protected $patterns = [
        '(:any)' => '(.*)',
        '(:num)' => '([0-9]*)'
    ];

    public function __construct($url, $controller, $method)
    {
        $this->setUrl($url);
        $this->setController($controller);
        $this->setAction($method);
    }

    public function match($url)
    {
        if (preg_match('`^' . $this->url . '$`', $url, $matches)) {
            return $matches;
        } else {
            //No match
            return false;
        }
    }

    public function setAction($action)
    {
        if (is_callable([$this->getController(), $action])) {
            $this->action = $action;
        } else {
            throw new \InvalidArgumentException('L\'action de la route est inaccesible ou inconnue (Voir fichier de config)');
        }
    }

    public function setController($controller)
    {
        if (class_exists('\\app\\Controllers\\' . $controller)) {
            $this->module = '\\app\\Controllers\\' . $controller;
        } else {
            throw new \InvalidArgumentException('La classe du controller \\app\\Controllers\\' .
            $controller . 'est inexistante (Voir fichier de config)');
        }
    }

    public function setUrl($url)
    {
        if (is_string($url)) {
            $finalUrl = '\\' . $url;
            foreach ($this->patterns as $key => $value) {
                $finalUrl = str_replace($key, $value, $finalUrl);
            }
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
        return $this->module;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setMatches($matches)
    {
        if (is_array($matches)) {
            $resultMatches = [];
            $numSlug = 1;
            foreach ($matches as $key => $value) {
                $resultMatches['slug' . $numSlug] = $value;
                $numSlug ++;
            }
            $this->matches = $resultMatches;
        }
    }

    public function getMatches()
    {
        return $this->matches;
    }
}
