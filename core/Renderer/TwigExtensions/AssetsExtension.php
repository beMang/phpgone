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
class AssetsExtension extends BaseTwigExtension
{
    protected $urlHelperInstance;

    public function __construct(Application $app){
        parent::__construct($app);
        $this->urlHelperInstance = new Url($app);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('css', [$this, 'css'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('js', [$this, 'js'], ['is_safe' => ['html']])
        ];
    }

    public function css($nameFile){
        return '<link rel="stylesheet" type="text/css" href="' . $this->urlHelperInstance->getRelativeAssetsPath() . 'css/' .$nameFile  . '.css">';
    }

    public function js($nameFile){
        return '<script src="' . $this->urlHelperInstance->getRelativeAssetsPath() . 'js/' .$nameFile  . '.js"></script>';
    }
}
