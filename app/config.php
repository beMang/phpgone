<?php

use phpGone\TwigExtensions\AssetsExtension;
use phpGone\TwigExtensions\UrlExtension;

$ctrlNamespace = '\\app\\Controllers\\';

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './app/views/',
    'publicPath' => './public/',
    'controllersPath' => ['./app/Controllers/', $ctrlNamespace],
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        UrlExtension::class,
        AssetsExtension::class
    ]
];
