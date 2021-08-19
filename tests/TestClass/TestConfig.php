<?php

namespace tests\TestClass;

$ctrlNamespace = '\\tests\\TestClass\\Controllers\\';

use phpGone\Router\Route;

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './tests/TestClass/views/',
    'assetsPath' => './tests/TestClass/assets/',
    'controllersPath' => ['./tests/TestClass/Controllers/', $ctrlNamespace],
    'routes' => [
        'index' => new Route('/', $ctrlNamespace . 'TestController', 'index'),
        'test' => new Route('/{testname}', $ctrlNamespace . 'TestController', 'test'),
        'redirect' => new Route('', $ctrlNamespace . 'TestController', 'redirect'),
        'parameters' => new Route('', $ctrlNamespace . 'TestController', 'parameters'),
        '404' => new Route('', $ctrlNamespace . 'TestController', 'error404')
    ], //Route de l'application
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
