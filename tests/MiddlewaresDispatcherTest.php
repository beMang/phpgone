<?php
namespace Test;

class MiddlewaresDispatcherTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass() :void
    {
        require_once(__DIR__ . '/../vendor/autoload.php');
    }
    
    public function testWithNullMiddlewares()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $this->expectExceptionMessage('Un middleware est mal configuré ou aucun middleware défini');
        $dispatcher = new \phpGone\Core\MiddlewaresHandler($app);
        $dispatcher->resetMiddlewares();
        $dispatcher->handle($request);
    }
}
