<?php

namespace phpGone\Router;

class Route
{
    protected $action;
    protected $controller;
    protected $url;
    protected $matches = null;

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
            return false;
        }
    }

    public function setAction($action)
    {
        if (is_string($action)) {
            $this->action = $action;
        } else {
            return false;
        }
    }

    public function setController($controller)
    {
        if (is_string($controller)) {
            $this->module = $controller;
        } else {
            return false;
        }
    }

    public function setUrl($url)
    {
        if (is_string($url)) {
            $this->url = $url;
        } else {
            return false;
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

    public function setMatches($matches){
        if(is_array($matches)){
            $resultMatches = [];
            $numSlug = 1;
            foreach ($matches as $key => $value) {
                $resultMatches['slug' . $numSlug] = $value;
                $numSlug ++;
            }
            $this->matches = $resultMatches;
        }
    }

    public function getMatches(){
        return $this->matches;
    }
}
