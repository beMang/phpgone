<?php
namespace Test;

class MiddlewaresDispatcherTest extends \PHPUnit\Framework\TestCase
{
    public function testWithNullMiddlewares()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $this->expectExceptionMessage('Aucun middleware a été défini');
        $dispatcher = new \phpGone\Core\MiddlewaresDispatcher($app);
        $dispatcher->resetMiddlewares();
        $dispatcher->process($request);
    }
}
