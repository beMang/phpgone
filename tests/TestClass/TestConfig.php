<?php

namespace tests\TestClass;

$ctrlNamespace = '\\tests\\TestClass\\Controllers\\';

use phpGone\Router\Route;
use phpGone\TwigExtensions\AssetsExtension;
use phpGone\TwigExtensions\UrlExtension;

return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './tests/TestClass/views/',
    'assetsPath' => './tests/TestClass/assets/',
    'controllersPath' => ['./tests/TestClass/Controllers/', $ctrlNamespace],
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        UrlExtension::class,
        AssetsExtension::class
    ]
];
