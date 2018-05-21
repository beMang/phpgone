<?php

namespace phpGone\Renderer;

use bemang\Config;

class Renderer
{

    public function render($view, $datas)
    {
        $urlHelper = new \phpGone\Helpers\Url();
        $fileToRender = $urlHelper->getAppPath() . 'views/' . $view . '.php';
        if (!file_exists($fileToRender)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas' . $fileToRender);
        }

        extract($datas);

        require $fileToRender;
    }

    public function twigRender($view, $datas)
    {
        $urlHelper = new \phpGone\Helpers\Url();
        $loaderTwig = new \Twig_Loader_Filesystem($urlHelper->getAppPath() . 'views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => false
        ]);
        foreach (Config::getInstance()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension());
        }
        echo $twig->render($view, $datas);
    }

    /*
    public static function twigRenderWithCache(){
        if (is_null($directory)) {
            $dir = __DIR__ . '../../../../../../tmp/cache/twig/';
        } else {
            $dir = $directory;
        }
        $loaderTwig = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/app/views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => $dir
        ]);
        //Ajout des extensions
        foreach ($this->getApp()->getCongig()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension);
        }
        return $twig->render($this->contentFile, $this->vars);
    }
    */
}
