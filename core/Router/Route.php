<?php

namespace phpGone\Router;

class Route
{
    protected $action;
    protected $module;
    protected $url;
    protected $varsNames;
    protected $vars = [];

    public function __construct($url, $module, $action, array $varsNames)
    {
        $this->setUrl($url);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVarsNames($varsNames);
    }

    public function hasVars()
    {
        if (empty($this->varsNames)) {
            return false;
        } else {
            return true;
        }
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
    public function setModule($module)
    {
        if (is_string($module)) {
            $this->module = $module;
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

    public function setVarsNames(array $varsNames)
    {
        $this->varsNames = $varsNames;
    }

    public function setVars(array $vars)
    {
        $this->vars = $vars;
    }

    //Getters
    public function getAction()
    {
        return $this->action;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getVars()
    {
        return $this->vars;
    }
    
    public function getVarsNames()
    {
        return $this->varsNames;
    }
}
