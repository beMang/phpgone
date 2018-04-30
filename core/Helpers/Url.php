<?php

namespace phpGone\Helpers;

use phpGone\Helpers\Helper;

class Url extends Helper{
    public function getTmpPath(){
        return __DIR__ . '/../../tmp/';
    }

    public function getAppPath(){
        return __DIR__ . '/../../app/';
    }

    public function getTestsPath(){
        return __DIR__ . '/../../tests/';
    }

    public function getAssetsPath(){
        return $this->getAppPath() . 'assets/';
    }

    public function getRelativeAssetsPath(){
        return $this->getRelativeAppPath() . 'assets/';
    }

    public function getRelativeAppPath(){
        return $this->getConfig()->get('basePath') . 'app/';
    }
}