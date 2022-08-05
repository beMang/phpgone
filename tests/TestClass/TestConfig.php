<?php

namespace tests\TestClass;

use phpGone\TwigExtensions\AssetsExtension;
use phpGone\TwigExtensions\UrlExtension;

return [
    'viewsPath' => './tests/TestClass/views',
    'controllersPath' => './tests/TestClass/Controllers',
    'controllersNamespace' => '\\tests\\TestClass\\Controllers\\',
    'publicPath' => './tests/TestClass/assets',
    'tmpPath' => './tests/TestClass/tmp',
    'defaultRender' => 'twig', //php or twig
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        UrlExtension::class,
        AssetsExtension::class
    ]
];
