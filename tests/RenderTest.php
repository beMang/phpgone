<?php
namespace Test;

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
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/doc');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $urlHelper = new \phpGone\Helpers\Url($app);
        $exptedPath = $urlHelper->getAppPath() . 'views/' . $view . '.php';
        $this->expectExceptionMessage('La vue spécifiée n\'existe pas' . $exptedPath);
        $render = new \phpGone\Renderer\Renderer($app);
        $render->render($view, []);
    }
}
