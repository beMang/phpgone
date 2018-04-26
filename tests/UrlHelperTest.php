<?php
namespace Test;

class UrlHelperTest extends \PHPUnit\Framework\TestCase{
    private $urlInstance;

    public function setUp(){
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $this->urlInstance = new \phpGone\Helpers\Url($app);
    }

    public function testTmpPath(){
        $this->assertDirectoryExists($this->urlInstance->getTmpPath());
    }

    public function testAppPath(){
        $this->assertDirectoryExists($this->urlInstance->getAppPath());
    }

    public function testTestsPath(){
        $this->assertDirectoryExists($this->urlInstance->getTestsPath());
    }
}