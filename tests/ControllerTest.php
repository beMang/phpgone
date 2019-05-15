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

    public function getTestController(Route $route, ServerRequest $request)
    {
        return new TestController($route, $request);
    }

    public function testError404()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/eadsdqf');
        $controller = $this->getTestController(Config::getInstance()->get('routes')['404'], $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
    }
}
