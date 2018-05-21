<?php
namespace Test;

class UrlHelperTest extends \PHPUnit\Framework\TestCase
{
    private $urlInstance;

    public static function setUpBeforeClass()
    {
        require(__DIR__ . '/../vendor/autoload.php');
    }
    
    public function setUp()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $this->urlInstance = new \phpGone\Helpers\Url($app);
    }

    public function testTmpPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getTmpPath());
        $basePath = $this->urlInstance->getTmpPath();
        $customPath = $this->urlInstance->getTmpPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testAppPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getAppPath());
        $basePath = $this->urlInstance->getAppPath();
        $customPath = $this->urlInstance->getAppPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testTestsPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getTestsPath());
        $basePath = $this->urlInstance->getTestsPath();
        $customPath = $this->urlInstance->getTestsPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testAssetsPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getAssetsPath());
        $basePath = $this->urlInstance->getAssetsPath();
        $customPath = $this->urlInstance->getAssetsPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testRelativeAssetsPath()
    {
        $this->assertDirectoryExists(dirname(__FILE__) . '/../' . $this->urlInstance->getRelativeAssetsPath());
        $basePath = $this->urlInstance->getRelativeAssetsPath();
        $customPath = $this->urlInstance->getRelativeAssetsPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testRelativeAppPath()
    {
        $this->assertDirectoryExists(dirname(__FILE__) . '/../' . $this->urlInstance->getRelativeAppPath());
        $basePath = $this->urlInstance->getRelativeAppPath();
        $customPath = $this->urlInstance->getRelativeAppPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }
}
