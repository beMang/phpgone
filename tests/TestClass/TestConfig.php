<?php

namespace tests\TestClass;

$ctrlNamespace = '\\tests\\TestClass\\Controllers\\';

use phpGone\TwigExtensions\AssetsExtension;
use phpGone\TwigExtensions\UrlExtension;

// TODO : confusion between assets path and public path
return [
    'defaultRender' => 'twig', //php or twig
    'viewsPath' => './tests/TestClass/views/',
    'assetsPath' => './tests/TestClass/assets/',
    'controllersPath' => ['./tests/TestClass/Controllers/', $ctrlNamespace],
    'publicPath' => './tests/TestClass/assets',
    'tmpPath' => './tests/TestClass/tmp',
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        UrlExtension::class,
        AssetsExtension::class
    ]
];
