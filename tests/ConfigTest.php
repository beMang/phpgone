<?php
namespace Test;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    protected $appInstance;

    public function setUp()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $this->appInstance = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
    }

    public function testConfig()
    {
        $this->appInstance->getConfig()->defineUnique('testphpunitexample', 'coucou');
        $this->assertArrayHasKey('testphpunitexample', $this->appInstance->getConfig()->getConfigArray());
    }

    public function testUnknowKey()
    {
        $this->assertFalse($this->appInstance->getConfig()->get(uniqid()));
    }

    public function testDefineFalseFile()
    {
        $this->assertFalse($this->appInstance->getConfig()->define(uniqid()));
    }
}
