<?php

$ctrlNamespace = '\\app\\Controllers\\';

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './app/views/',
    'publicPath' => './public/',
    'controllersPath' => ['./app/Controllers/', $ctrlNamespace],
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
