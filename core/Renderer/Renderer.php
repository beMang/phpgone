<?php

namespace phpGone\Renderer;

use phpGone\Core\ApplicationComponent;

class Renderer{

    public static function render($view, $datas){
        if (!file_exists($fileToRender)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas' . $fileToRender);
        }

        extract($datas);

        require $fileToRender;
    }

    public static function twigRender($view, $datas){
        $loaderTwig = new \Twig_Loader_Filesystem(__DIR__ . '/../../app/views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => false
        ]);
        /*
        Extension
        foreach ($this->getApp()->getConfig()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension);
        }
        */
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