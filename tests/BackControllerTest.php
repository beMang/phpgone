<?php
namespace Test;

use phpGone\Router\Route;

class BackControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testInvalidAction()
    {
        $action = uniqid();
        $this->expectExceptionMessage('L\'action' . $action . 'n\'est pas définie sur ce controller');
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->getConfig()->defineUnique('routes', [
            new Route('/', 'Show\Show', $action, [])
        ]);
        $app->run();
    }

    public function testInvalidActionString()
    {
        $action = '';
        $this->expectExceptionMessage('L\'action doit être une chaine de caractères valide');
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->getConfig()->defineUnique('routes', [
            new Route('/', 'Show\Show', $action, [])
        ]);
        $app->run();
    }

    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testInvalidController()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $app->getConfig()->defineUnique('routes', [
            new Route('/', 'Sfdsqfdsq\fdsqml', $action, [])
        ]);
        $app->run();
    }
}
