<?php

namespace tests;

use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Core\Application;
use phpGone\Core\MiddlewaresHandler;
use PHPUnit\Framework\TestCase;

class MiddlewaresDispatcherTest extends TestCase
{

    public function testWithNullMiddlewares()
    {
        $request = new ServerRequest('GET', '/');
        $app = new Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $this->expectExceptionMessage('Un middleware est mal configuré ou aucun middleware défini');
        $dispatcher = new MiddlewaresHandler($app);
        $dispatcher->resetMiddlewares();
        $dispatcher->handle($request);
    }
}
