<?php
/**
 * Fichier de configuration de base du framework (obligatoire pour le bon fonctionnement)
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */

 //USAGE

use phpGone\Log\Logger;
use phpGone\Router\Routeur;
use phpGone\Session\Session;
use GuzzleHttp\Psr7\Response;
use phpGone\Core\Application;
use phpGone\Renderer\PhpRenderer;
use phpGone\Database\DatabasePDO;
use phpGone\Renderer\TwigRenderer;
use phpGone\Core\MiddlewaresDispatcher;

return[
    'TwigExtensions' => [
        phpGone\Renderer\TwigExtensions\FormExtension::class,
        phpGone\Renderer\TwigExtensions\FlashExtension::class
    ],
    'database.host' => 'mysql:host=localhost;dbname=test',
    'database.user' => 'root',
    'database.password' => 'Ka#W6#m$',
    'routesConfigFiles' => 'test'
];
