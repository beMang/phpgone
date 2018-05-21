<?php
/**
 * Fichier de la classe UrlExtension
 *
 * PHP Version 7
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Renderer\TwigExtensions;

use phpGone\Helpers\Url;
use phpGone\Core\Application;
use phpGone\Renderer\TwigExtensions\BaseTwigExtension;

/**
 * @example Cette classe est un exemple (incomplet) d'une extension twig
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
