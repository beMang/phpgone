<?php

namespace tests;

use bemang\Config;
use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Core\Application;
use phpGone\Helpers\Url;
use PHPUnit\Framework\TestCase;

class UrlHelperTest extends TestCase
{
    private Url $urlInstance;

    public function setUp(): void
    {
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/TestClass/TestConfig.php'));

        $request = new ServerRequest('GET', '/');
        $app = new Application(Config::getInstance(), $request);
        $this->urlInstance = new Url($app);
    }

    public function testTmpPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getTmpPath());
        $basePath = $this->urlInstance->getTmpPath();
        $customPath = $this->urlInstance->getTmpPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testTestsPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getTestsPath());
        $basePath = $this->urlInstance->getTestsPath();
        $customPath = $this->urlInstance->getTestsPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }

    public function testPublicPath()
    {
        $this->assertDirectoryExists($this->urlInstance->getPublicPath());
        $basePath = $this->urlInstance->getPublicPath();
        $customPath = $this->urlInstance->getPublicPath('test');
        $this->assertEquals($basePath . 'test/', $customPath);
    }
}
