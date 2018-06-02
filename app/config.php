<?php

use phpGone\Router\Route;

return [
    'basePath' => '/', //base path for de application (better to no change)
    'routes' => [
        new Route('/', 'Demo\Show', 'index'),
        new Route('/doc', 'Demo\Show', 'doc')
    ], //Route de l'application
    'errorPage' => ['Error\Error', 'index'], //Page pour les erreurs 404
    'TwigExtensions' => [ //Extensions twig à charger pour le rendu
        phpGone\Renderer\TwigExtensions\UrlExtension::class,
        phpGone\Renderer\TwigExtensions\AssetsExtension::class
    ]
];
