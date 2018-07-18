<?php

use phpGone\Router\Route;

return [
    'basePath' => '/', //base path for de application (better to no change)
    'routes' => [
        new Route('/doc/{nom}/{hello|}', 'Demo\Show', 'doc'),
        new Route('/', 'Demo\Show', 'index')
    ], //Route de l'application
    'errorPage' => ['Error\Error', 'index'], //Page pour les erreurs 404
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        phpGone\Renderer\TwigExtensions\UrlExtension::class,
        phpGone\Renderer\TwigExtensions\AssetsExtension::class
    ]
];
