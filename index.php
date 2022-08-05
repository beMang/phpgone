<?php

use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Middlewares\TrailingSlashMiddleware;

require __DIR__ . "/vendor/autoload.php";

//TODO : créer une configuration à passer la l'application et l'application vérifie la validité de la configuration donnée

$app = new phpGone\Core\Application(__DIR__ . '/app/config.php', ServerRequest::fromGlobals());
$app->addMiddleware(TrailingSlashMiddleware::class); //Ajout des middlewares
$response = $app->run();
$app->send();
