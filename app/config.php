<?php

use phpGone\Router\Route;

return [
    'basePath' => '/',
    'routes' => [
        new Route('^[\/]$', 'Show\Show', 'index', ['test']),
        new Route('/doc', 'Show\Show', 'Doc', [])
    ],
    'viewError404' => 'Error/show.twig',
    'TwigExtensions' => [
        phpGone\Renderer\TwigExtensions\UrlExtension::class,
        phpGone\Renderer\TwigExtensions\AssetsExtension::class
    ]
];
