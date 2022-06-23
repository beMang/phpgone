<?php

namespace tests;

use phpGone\Core\Application;
use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Middlewares\TrailingSlashMiddleware;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    public function testIndex()
    {
        $request = new ServerRequest('GET', '/');
        $app = new Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $app->addMiddleware(TrailingSlashMiddleware::class);
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertEquals('home', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);
    }

    public function testTrailingSlashMiddleware()
    {
        $request = new ServerRequest('GET', '/asfdsq/');
        $app = new Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddleware(TrailingSlashMiddleware::class);
        $response = $app->run();
        $this->assertEquals(301, $response->getStatusCode(301));
        $this->assertEquals('/asfdsq', $response->getHeaders()['Location'][0]);
    }

    public function testError404()
    {
        $request = new ServerRequest('GET', '/error/404/fmdskqq');
        $app = new Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddleware(TrailingSlashMiddleware::class);
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
    }

    /**
     * @runInSeparateProcess
     */
    public function testSender()
    {
        $request = new ServerRequest('GET', '/', ['Host' => 'local']);
        $app = new Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $response = $app->run();
        $this->assertTrue($app->send());
    }

    public function testGetRequest()
    {
        $request = new ServerRequest('GET', '/');
        $app = new Application(__DIR__ . '/TestClass/TestConfig.php', $request);
        $this->assertEquals($request, $app->getRequest());
    }
}
