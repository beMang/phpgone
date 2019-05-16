<?php
namespace tests;

use bemang\Config;
use phpGone\Router\Route;
use phpGone\Core\Application;
use GuzzleHttp\Psr7\ServerRequest;
use tests\TestClass\TestController;

class ControllerTest extends \PHPUnit\Framework\TestCase
{

    public function setUp() :void
    {
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/TestClass/TestConfig.php'));
    }

    public function getTestController(string $routeName, ServerRequest $request) :TestController
    {
        $route = Config::getInstance()->get('routes')[$routeName];
        $route->match($request->getUri());
        return new TestController($route, $request);
    }

    public function testError404()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/eadsdqf');
        $controller = $this->getTestController('404', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 404);

        //again for another way into the controller
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/error');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testRedirection()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/redirect');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Redirect', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 301);
    }
}
