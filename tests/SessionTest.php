<?php
namespace Test;

use Psr\Log\LogLevel;

class SessionTest extends \PHPUnit\Framework\TestCase
{
    protected $sessionInstance;

    public function setUp()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $this->sessionInstance = new \phpGone\Helpers\Session($app);
    }

    public function testAllFunction()
    {
        $this->sessionInstance->addAttr('testunit', 'test');
        $this->assertEquals('test', $_SESSION['testunit']);
        $this->assertEquals('test', $this->sessionInstance->getAttr('testunit'));
        $this->assertTrue($this->sessionInstance->hasAttr('testunit'));
        $this->sessionInstance->updateAttr('testunit', 'test2');
        $this->assertEquals('test2', $_SESSION['testunit']);
        $this->assertEquals('test2', $this->sessionInstance->getAttr('testunit'));
        $this->sessionInstance->removeAttr('testunit');
        $this->assertArrayNotHasKey('testunit', $_SESSION);
        $this->assertFalse($this->sessionInstance->hasAttr(uniqid()));
        $this->assertFalse($this->sessionInstance->updateAttr(uniqid(), 'jkmlf'));
    }
}
