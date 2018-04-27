<?php

namespace phpGone\Renderer;

use phpGone\Core\ApplicationComponent;

class Renderer extends ApplicationComponent
{

    public function render($view, $datas)
    {
        $urlHelper = new \phpGone\Helpers\Url($this->getApp());
        $fileToRender = $urlHelper->getAppPath() . 'views/' . $view . '.php';
        if (!file_exists($fileToRender)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas' . $fileToRender);
        }

        extract($datas);

        require $fileToRender;
    }

    public function twigRender($view, $datas)
    {
        $urlHelper = new \phpGone\Helpers\Url($this->getApp());
        $loaderTwig = new \Twig_Loader_Filesystem($urlHelper->getAppPath() . 'views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => false
        ]);
        foreach ($this->getConfig()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension($this->getApp()));
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
