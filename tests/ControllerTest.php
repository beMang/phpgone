<?php

namespace tests;

use bemang\Config;
use phpGone\Router\Route;
use phpGone\Core\Application;
use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Router\Routeur;
use PHPUnit\Framework\TestCase;
use tests\TestClass\Controllers\TestController;

class ControllerTest extends TestCase
{
    public function setUp(): void
    {
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/TestClass/TestConfig.php'));
    }

    public function getTestController(string $routeName, ServerRequest $request): TestController
    {
        $routeur = new Routeur();
        $route = $routeur->getAttributesRoutes()[$routeName];
        $route->match($request->getUri());
        return new TestController($route, $request);
    }

    public function testError404()
    {
        $request = new ServerRequest('GET', '/eadsdqf');
        $controller = $this->getTestController('error404', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 404);

        //again for another way into the controller
        $request = new ServerRequest('GET', '/error');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Error 404', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 404);
    }

    public function testRedirection()
    {
        $request = new ServerRequest('GET', '/redirect');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('Redirect', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 301);
    }

    public function testBadRedirection()
    {
        $request = new ServerRequest('GET', '/redirectfalse');
        $controller = $this->getTestController('test', $request);
        $this->expectExceptionMessage('Route inconnue ou invalide');
        $response = $controller->execute();
    }

    public function testParameters()
    {
        $request = new ServerRequest('GET', '/');
        $controller = $this->getTestController('parameters', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('OK', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);

        Config::getInstance()->define('defaultRender', 'php');
        $request = new ServerRequest('GET', '/');
        $controller = $this->getTestController('parameters', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('OK', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);
        Config::getInstance()->define('', 'twig');
    }

    public function testAllRender()
    {
        $request = new ServerRequest('GET', '/render');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('test', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);

        Config::getInstance()->define('defaultRender', 'php');
        $request = new ServerRequest('GET', '/render');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('test', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);
        Config::getInstance()->define('', 'twig');

        $request = new ServerRequest('GET', '/phprender');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('test', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);

        $request = new ServerRequest('GET', '/twigrender');
        $controller = $this->getTestController('test', $request);
        $response = $controller->execute();
        $stream = $response->getBody();
        $stream->rewind();
        $this->assertSTringContainsString('test', $stream->read(1024 * 8));
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
