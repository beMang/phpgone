<?php

namespace phpGone\Helpers;

use \bemang\Config;

class Url
{
    public function getTmpPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return __DIR__ . '/../../tmp/' . $custom;
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
        return $this->getAppPath('assets') . $custom;
    }

    public function getRelativeAssetsPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return $this->getRelativeAppPath('assets') . $custom;
    }

    public function getRelativeAppPath($custom = null)
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return Config::getInstance()->get('basePath') . 'app/' . $custom;
    }
}
