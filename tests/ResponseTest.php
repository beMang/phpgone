<?php
namespace Test;

use phpGone\Core\Application;
use GuzzleHttp\Psr7\ServerRequest;

class TestResponse extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        require "vendor/autoload.php";
        $_SERVER['DOCUMENT_ROOT'] = 'C:\Users\adrie\Desktop\Jeux\Site\exemplePhpGone\tests';
    }

    public function testError404()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/eadsdqf');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddlewares('TrailingSlashMiddleware');
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertContains('<h1>Error 404</h1>', $stream->read(1024 * 8));
    }

    public function testNewsIndex()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/news');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddlewares('TrailingSlashMiddleware');
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertContains('<h1>Test d\'un module de news avec phpGone</h1>', $stream->read(1024 * 8));
    }

    public function testTrailingSlashMiddleware()
    {
        $request = new ServerRequest('GET', '/asfdsq/');
        $app = new Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddlewares('TrailingSlashMiddleware');
        $response = $app->run();
        $this->assertEquals(301, $response->getStatusCode(301));
        var_dump($response->getHeaders());
        $this->assertEquals('/asfdsq', $response->getHeaders()['Location'][0]);
    }
}
