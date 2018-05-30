<?php

use phpGone\Router\Route;

return [
    'basePath' => '/',
    'routes' => [
        new Route('/', 'Show\Show', 'index'),
        new Route('/doc', 'Show\Show', 'doc')
    ],
    'errorPage' => ['Error\Error', 'index'],
    'TwigExtensions' => [
        phpGone\Renderer\TwigExtensions\UrlExtension::class,
        phpGone\Renderer\TwigExtensions\AssetsExtension::class
    ]
];
