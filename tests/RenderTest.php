<?php
namespace Test;

class RenderTest extends \PHPUnit\Framework\TestCase{
    public function testDefaultRender(){
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/doc');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->addMiddlewares('TrailingSlashMiddleware');
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertContains('<h1>La documentation va être écrite</h1>', $stream->read(1024 * 8));
    }
}