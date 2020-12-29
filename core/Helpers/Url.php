<?php

namespace phpGone\Helpers;

use \bemang\Config;

/**
 * Class permettant de récupérer les url des dossiers principaux
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
        return Config::getInstance()->get('publicPath') . $custom;
    }

    public function getRelativeAssetsPath($custom = null)
    {
        return $this->getAssetsPath($custom);
    }
}
