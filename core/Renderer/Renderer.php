<?php

namespace phpGone\Renderer;

use phpGone\Core\ApplicationComponent;

class Renderer{

    public static function render($view, $datas){
        $fileToRender = __DIR__ . '/../../app/views/' . $view;
        if (!file_exists($fileToRender)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas' . $fileToRender);
        }

        extract($datas);

        require $fileToRender;
    }

    public static function twigRender($view, $datas){
        //TO_DO
    }
}