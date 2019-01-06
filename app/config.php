<?php

use phpGone\Router\Route;

return [
    'basePath' => '/', //base path for de application (better to no change)
    'defaultRender' => 'twig', //php or twig
    'routes' => [
        'doc' => new Route('/doc', 'Demo\Show', 'doc'),
        'home' => new Route('/', 'Demo\Show', 'index'),
        'testnum' => new Route('/{num|}', 'Demo\Show', 'demonum'),
        '404' => new Route('', 'Error\Error', 'index')
    ], //Route de l'application
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
