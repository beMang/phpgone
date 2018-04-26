<?php
namespace Test;

class BaseTwigExtensionTest extends \PHPUnit\Framework\TestCase{
    protected $appInstance;

    public function setUp(){
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $this->appInstance = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
    }

    public function testMultipleHeritage(){
        $extension = new \phpGone\Renderer\TwigExtensions\UrlExtension($this->appInstance);
        $this->assertEquals($extension->getApp(), $this->appInstance);
    }
}