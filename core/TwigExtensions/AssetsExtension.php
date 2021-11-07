<?php

namespace phpGone\TwigExtensions;

use Twig\TwigFunction;
use phpGone\Helpers\Url;
use Twig\Extension\AbstractExtension;

/**
 * Extension twig pour ajouter des assets facilement
 */
class AssetsExtension extends AbstractExtension
{
    protected $urlHelperInstance;

    public function __construct()
    {
        $this->urlHelperInstance = new Url();
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('css', [$this, 'css'], ['is_safe' => ['html']]),
            new TwigFunction('js', [$this, 'js'], ['is_safe' => ['html']])
        ];
    }

    public function css($nameFile)
    {
        if (is_string($nameFile)) {
            $result = '<link rel="stylesheet" type="text/css" href="' .
            $this->urlHelperInstance->getRelativeAssetsPath() .
            'css/' . $nameFile  . '.css">';
        } elseif (is_array($nameFile)) {
            $result = '';
            foreach ($nameFile as $file) {
                $result = $result . '
                <link rel="stylesheet" type="text/css" href="' .
                $this->urlHelperInstance->getRelativeAssetsPath() . 'css/' .
                $file  . '.css">';
            }
        }
        return $result;
    }

    public function js($nameFile)
    {
        if (is_string($nameFile)) {
            $result = '<script src="' .
            $this->urlHelperInstance->getRelativeAssetsPath() .
            'js/' . $nameFile  . '.js"></script>';
        } elseif (is_array($nameFile)) {
            $result = '';
            foreach ($nameFile as $file) {
                $result = $result . '
                <script src="' .
                $this->urlHelperInstance->getRelativeAssetsPath() .
                'js/' . $file  . '.js"></script>';
            }
        }
        return $result;
    }
}
