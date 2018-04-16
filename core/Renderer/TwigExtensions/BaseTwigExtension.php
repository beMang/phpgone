<?php

namespace phpGone\Renderer\TwigExtensions;

use phpGone\Core\Application;
use phpGone\Core\ApplicationComponent;

class BaseTwigExtension extends \Twig_Extension
{
    protected $applicationComponentInstance = null;

    public function __construct(Application $app)
    {
        $this->setApplicationComponentInstance(new ApplicationComponent($app));
    }

    private function setApplicationComponentInstance(ApplicationComponent $appComponent)
    {
        $this->applicationComponentInstance = $appComponent;
    }

    public function __call($funcName, $args)
    {
        if (method_exists($this->applicationComponentInstance, $funcName)) {
            return call_user_func_array(array($this->applicationComponentInstance, $funcName), $args);
        } else {
            throw new Exception("The $funcName method doesn't exist - BaseTwigExtension.php - Line 23");
        }
    }
}
