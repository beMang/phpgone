<?php
namespace Test;

use bemang\Cache\FileCache;
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
        $this->expectExceptionMessage('Le cache doit être un booléen');
        Renderer::render('test', [], 'jlkmf');
    }

    public function testRenderWithInexistantView()
    {
        $view = uniqid();
        $this->expectExceptionMessage('La vue spécifiée n\'existe pas' . $view);
        Renderer::render($view, []);
    }

    public function testUnknowCacheTypeTwig()
    {
        $this->expectExceptionMessage('Le cache doit être un booléen');
        Renderer::twigRender('test', [], 'jlkmf');
    }

    public function testCacheRender()
    {
        ob_start();
        Renderer::render('Demo/doc', [], true);
        $content = ob_get_clean();
        $cache = new FileCache(__DIR__ . '/../tmp/cache/phpgone/');
        $this->assertEquals($cache->get('phpGoneCacheDemo/doc'), $content);
        ob_start();
        Renderer::render('Demo/doc', [], true);
        $newContent = ob_get_clean();
        $this->assertEquals($cache->get('phpGoneCacheDemo/doc'), $newContent);
        ob_start();
        Renderer::render('Demo/forTest', [], true);
        $newContent = ob_get_clean();
        $this->assertEquals($cache->get('phpGoneCacheDemo/forTest'), $newContent);
    }

    public function testCacheRenderWithInexistantView()
    {
        $view = uniqid();
        $this->expectExceptionMessage('La vue spécifiée n\'existe pas' . $view);
        Renderer::render($view, [], true);
    }
}
