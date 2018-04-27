<?php

use phpGone\Router\Route;

return [
    'defaultMainRender' => 'Twig',
    'defaultAsset' => 'site',
    'routes' => [
        new Route('^[\/]$', 'Show\Show', 'index', ['test']),
        new Route('/doc', 'Show\Show', 'Doc', [])
    ],
    'viewError404' => 'Error/show.twig'
];
