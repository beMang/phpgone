<?php

namespace phpGone\Renderer;

use bemang\Config;
use phpGone\Helpers\Url;
use bemang\Cache\FileCache;

class Renderer
{
    const NAME_CACHE = 'phpGoneCache';

    public static function render($view, $datas, $cache = false)
    {
        if (is_bool($cache)) {
            if ($cache === false) {
                self::classicRender($view, $datas);
            } else {
                self::cacheRender($view, $datas);
            }
        } else {
            throw new \InvalidArgumentException('Le cache doit être un booléen');
        }
    }

    public static function twigRender($view, $datas, $cache = false)
    {
        if (is_bool($cache)) {
            if ($cache === false) {
                self::classicTwigRender($view, $datas);
            } else {
                self::cacheTwigRender($view, $datas);
            }
        } else {
            throw new \InvalidArgumentException('Le cache doit être un booléen');
        }
    }

    protected static function classicRender($view, $datas)
    {
        $urlHelper = new Url();
        $fileToRender = $urlHelper->getAppPath() . 'views/' . $view . '.php';
        if (!file_exists($fileToRender)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas' . $view);
        }
        extract($datas);
        require $fileToRender;
    }

    protected static function cacheRender($view, $datas)
    {
        $urlHelper = new Url();
        $cache = new FileCache($urlHelper->getTmpPath('cache/phpgone'));
        if ($cache->has(self::NAME_CACHE) === true) {
            echo $cache->get(self::NAME_CACHE);
        } else {
            $fileToRender = $urlHelper->getAppPath('views') . $view . '.php';
            if (!file_exists($fileToRender)) {
                throw new \RuntimeException('La vue spécifiée n\'existe pas' . $view);
            }
            ob_start();
            extract($datas);
            require $fileToRender;
            $content = ob_get_clean();
            $cache->set(self::NAME_CACHE, $content);
            echo $content;
        }
    }

    protected static function classicTwigRender($view, $datas)
    {
        $urlHelper = new Url();
        $loaderTwig = new \Twig_Loader_Filesystem($urlHelper->getAppPath() . 'views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => false
        ]);
        foreach (Config::getInstance()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension());
        }
        echo $twig->render($view, $datas);
    }

    protected static function cacheTwigRender($view, $datas)
    {
        $urlHelper = new Url();
        $loaderTwig = new \Twig_Loader_Filesystem($urlHelper->getAppPath('views'));
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => $urlHelper->getTmpPath('cache/twig')
        ]);
        foreach (Config::getInstance()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension);
        }
        echo $twig->render($view, $datas);
    }
}
