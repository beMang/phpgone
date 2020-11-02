<?php

use phpGone\Router\Route;

$ctrlNamespace = '\\app\\Controllers\\';

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './app/views/',
    'publicPath' => './public/',
    'routes' => [
        'doc' => new Route('/doc', $ctrlNamespace . 'Demo\Show', 'doc'),
        'home' => new Route('/', $ctrlNamespace . 'Demo\Show', 'index'),
        'testnum' => new Route('/{num|}', $ctrlNamespace . 'Demo\Show', 'demonum'),
        '404' => new Route('', $ctrlNamespace . 'Error\Error', 'index')
    ], //Route de l'application
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
