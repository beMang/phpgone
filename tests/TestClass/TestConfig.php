<?php

namespace tests\TestClass;

$ctrlNamespace = '\\tests\\TestClass\\Controllers\\';

use phpGone\Router\Route;

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './tests/TestClass/views/',
    'assetsPath' => './tests/TestClass/assets/',
    'controllersPath' => ['./tests/TestClass/Controllers/', $ctrlNamespace],
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        \phpGone\TwigExtensions\UrlExtension::class,
        \phpGone\TwigExtensions\AssetsExtension::class
    ]
];
