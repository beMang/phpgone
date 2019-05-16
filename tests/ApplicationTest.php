<?php

namespace tests;

class ApplicationTest extends \PHPUnit\Framework\TestCase
{
    public function testIndex()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $app->addMiddleware(\phpGone\Middlewares\TrailingSlashMiddleware::class);
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertEquals('home', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
