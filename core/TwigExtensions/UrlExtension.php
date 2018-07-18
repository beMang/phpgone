<?php

namespace phpGone\TwigExtensions;

use phpGone\Helpers\Url;
use phpGone\Core\Application;

/**
 * Extension twig facilitant l'accès aux url
 */
class UrlExtension extends \Twig_Extension
{
    protected $urlHelperInstance;

    public function __construct()
    {
        $this->urlHelperInstance = new Url();
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('tmpPath', [$this->urlHelperInstance, 'getTmpPath']),
            new \Twig_SimpleFunction('appPath', [$this->urlHelperInstance, 'getAppPath']),
            new \Twig_SimpleFunction('testsPath', [$this->urlHelperInstance, 'getTestsPath'])
        ];
    }
}
