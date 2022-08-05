<?php

namespace tests;

use bemang\Config;
use phpGone\Core\Application;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Core\MiddlewaresHandler;

class MiddlewaresDispatcherTest extends TestCase
{
    public function setUp(): void
    {
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/TestClass/TestConfig.php'));
    }

    public function testWithNullMiddlewares()
    {
        $request = new ServerRequest('GET', '/');
        $app = new Application(Config::getInstance(), $request);
        $this->expectExceptionMessage('Un middleware est mal configuré ou aucun middleware défini');
        $dispatcher = new MiddlewaresHandler($app);
        $dispatcher->resetMiddlewares();
        $dispatcher->handle($request);
    }
}
