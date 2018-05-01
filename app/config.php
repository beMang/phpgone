<?php

use phpGone\Router\Route;

return [
    'basePath' => '/',
    'routes' => [
        new Route('/', 'Show\Show', 'index'),
        new Route('/doc/(:any)', 'Show\Show', 'Doc')
    ],
    'viewError404' => 'Error/show.twig',
    'TwigExtensions' => [
        phpGone\Renderer\TwigExtensions\UrlExtension::class,
        phpGone\Renderer\TwigExtensions\AssetsExtension::class
    ]
];
