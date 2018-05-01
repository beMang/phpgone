<?php

namespace phpGone\Helpers;

use phpGone\Helpers\Helper;

class Url extends Helper
{
    public function getTmpPath($custom = '')
    {
        return __DIR__ . '/../../tmp/' . $custom;
    }

    public function getAppPath($custom = '')
    {
        return __DIR__ . '/../../app/' . $custom;
    }

    public function getTestsPath($custom = '')
    {
        return __DIR__ . '/../../tests/' . $custom;
    }

    public function getAssetsPath($custom = '')
    {
        return $this->getAppPath('assets/');
    }

    public function getRelativeAssetsPath($custom = '')
    {
        return $this->getRelativeAppPath('assets/');
    }

    public function getRelativeAppPath($custom = '')
    {
        return $this->getConfig()->get('basePath') . 'app/' . $custom;
    }
}
