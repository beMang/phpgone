<?php
session_start();
require __DIR__ . "/vendor/autoload.php";

$app = new phpGone\Core\Application(__DIR__ . '/app/config.php', \GuzzleHttp\Psr7\ServerRequest::fromGlobals());
$app->addMiddlewares(\phpGone\Middlewares\TrailingSlashMiddleware::class);
$response = $app->run();
$app->send();

/**$manager = \phpGone\Database\DBManager::getInstance($app);
$manager->addDatabase('base');

$query = new \phpGone\Database\Query('user_test', 'base');
$object = $query->getEmptyInstance();
$object->surname = 'coucou';
$object->pseudo = 'bemang';
$query->insert($object); */
