<?php

namespace phpGone\Helpers;

use phpGone\Helpers\Helper;

class Url extends Helper
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
        return $this->getConfig()->get('basePath') . 'app/' . $custom;
    }
}
