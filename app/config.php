<?php

use phpGone\Router\Route;

return [
    'defaultMainRender' => 'Twig',
    'defaultAsset' => 'site',
    'routes' => [
        new Route('^[\/]$', 'Show', 'index', ['test'])
    ]
];
