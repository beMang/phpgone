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
        'test' => new Route('/{testname}', $ctrlNamespace . 'TestController', 'test'),
        'redirect' => new Route('/', $ctrlNamespace . 'TestController', 'redirect'),
        'parameters' => new Route('/', $ctrlNamespace . 'TestController', 'parameters'),
        '404' => new Route('', $ctrlNamespace . 'TestController', 'error404')
    ], //Route de l'application
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
