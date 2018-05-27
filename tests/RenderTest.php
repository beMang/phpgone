<?php
namespace Test;

use phpGone\Renderer\Renderer;

class RenderTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
    {
        require_once(__DIR__ . '/../vendor/autoload.php');
    }
    
    public function testDefaultRender()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/doc');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $response = $app->run();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertContains('<h1>La documentation va être écrite</h1>', $stream->read(1024 * 8));
    }

    public function testRenderWithInexistantView()
    {
        $view = uniqid();
        $this->expectExceptionMessage('La vue spécifiée n\'existe pas' . $view);
        Renderer::render($view, []);
    }
}
