<?php

namespace phpGone\Helpers;

use \bemang\Config;

/**
 * Class permettant de récupérer les url des dossiers principaux
 * @todo Prendre en compte le base path
 */
class Url
{
    public function getTmpPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return __DIR__ . '/../../tmp/' . $custom;
    }

    public function getViewsPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return Config::getInstance()->get('viewsPath') . $custom;
    }

    public function getAppPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return __DIR__ . '/../../app/' . $custom;
    }

    public function getTestsPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return __DIR__ . '/../../tests/' . $custom;
    }

    public function getAssetsPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return Config::getInstance()->get('assetsPath') . $custom;
    }

    public function getRelativeAssetsPath($custom = null)
    {
        return $this->getAssetsPath($custom);
    }

    public function getRelativeAppPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return Config::getInstance()->get('basePath') . 'app/' . $custom;
    }
}
