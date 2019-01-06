<?php

require __DIR__ . "/vendor/autoload.php";

$app = new phpGone\Core\Application(__DIR__ . '/app/config.php', \GuzzleHttp\Psr7\ServerRequest::fromGlobals());
$app->addMiddleware(\phpGone\Middlewares\TrailingSlashMiddleware::class); //Ajout des middlewares
$response = $app->run();
$app->send();
