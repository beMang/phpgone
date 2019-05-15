<?php

namespace tests\TestClass;

$ctrlNamespace = '\\tests\\TestClass\\';

use \phpGone\Router\Route;

return [
    'basePath' => '/', //base path for de application (better to no change)
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './tests/TestClass/views/',
    'assetsPath' => './tests/TestClass/assets/',
    'routes' => [
        'doc' => new Route('/doc', $ctrlNamespace . 'TestController', 'doc'),
        'home' => new Route('/', $ctrlNamespace . 'TestController', 'index'),
        'testnum' => new Route('/{num|}', $ctrlNamespace . 'TestController', 'demonum'),
        '404' => new Route('', $ctrlNamespace . 'TestController', 'error404')
    ], //Route de l'application
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
