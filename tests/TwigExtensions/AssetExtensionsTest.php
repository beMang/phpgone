<?php

namespace tests\TwigExtensions;

use bemang\Config;
use phpGone\Helpers\Url;
use PHPUnit\Framework\TestCase;
use phpGone\TwigExtensions\AssetsExtension;

class AssetExtensionsTest extends TestCase
{
    protected $assetExtension;
    protected Url $urlHelper;

    public function setUp(): void
    {
        $extension = new AssetsExtension();
        $this->assetExtension = $extension;
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/../TestClass/TestConfig.php'));
        $this->urlHelper = new Url();
    }

    public function testCss()
    {
        $publicPath = $this->urlHelper->getPublicPath();
        $result = $this->assetExtension->css('test');
        $expected = '<link rel="stylesheet" type="text/css" href="' . $publicPath . 'css/test.css">';
        $this->assertEquals($expected, $result);
        $result = $this->assetExtension->css(['test', 'test2']);
        $this->assertSTringContainsString('<link rel="stylesheet" type="text/css" href="' . $publicPath . 'css/test.css">', $result);
        $this->assertSTringContainsString('<link rel="stylesheet" type="text/css" href="' . $publicPath . 'css/test2.css">', $result);
    }

    public function testJs()
    {
        $publicPath = $this->urlHelper->getPublicPath();
        $result = $this->assetExtension->js('test');
        $expected = '<script src="' . $publicPath . 'js/test.js"></script>';
        $this->assertEquals($expected, $result);
        $result = $this->assetExtension->js(['test', 'test2']);
        $this->assertSTringContainsString('<script src="' . $publicPath . 'js/test.js"></script>', $result);
        $this->assertSTringContainsString('<script src="' . $publicPath . 'js/test2.js"></script>', $result);
    }
}
