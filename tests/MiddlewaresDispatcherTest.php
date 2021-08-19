<?php

namespace tests;

class MiddlewaresDispatcherTest extends \PHPUnit\Framework\TestCase
{

    public function testWithNullMiddlewares()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $this->expectExceptionMessage('Un middleware est mal configuré ou aucun middleware défini');
        $dispatcher = new \phpGone\Core\MiddlewaresHandler($app);
        $dispatcher->resetMiddlewares();
        $dispatcher->handle($request);
    }
}
