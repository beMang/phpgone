<?php

namespace phpGone\Helpers;

use bemang\Config;
use bemang\ConfigException;
use bemang\InvalidArgumentExceptionConfig;

/**
 * Class permettant de récupérer les url des dossiers principaux
 */
class Url
{
    /**
     * @param string|null $custom
     * @return string
     */
    public function getTmpPath(string $custom = null): string
    {
        $custom = (!is_null($custom)) ? '/' . $custom . '/' : '/';
        return Config::getInstance()->get('tmpPath') . $custom;
    }

    /**
     * @throws InvalidArgumentExceptionConfig
     * @throws ConfigException
     */
    public function getViewsPath(string $custom = null): string
    {
        $custom = (!is_null($custom)) ? '/' . $custom . '/' : '/';
        return Config::getInstance()->get('viewsPath') . $custom;
    }

    /**
     * @param string|null $custom
     * @return string
     */
    public function getTestsPath(string $custom = null): string
    {
        $custom = (!is_null($custom)) ? $custom . '/' : '';
        return __DIR__ . '/../../tests/' . $custom;
    }

    /**
     * @param string|null $custom
     * @return string
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function getPublicPath(string $custom = null): string
    {
        $custom = (!is_null($custom)) ? '/' . $custom . '/' : '/';
        return Config::getInstance()->get('publicPath') . $custom;
    }
}
