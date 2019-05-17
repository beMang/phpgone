<?php

namespace tests\TwigExtensions;

use bemang\Config;
use \phpGone\TwigExtensions\AssetsExtension;

class AssetExtensionsTest extends \PHPUnit\Framework\TestCase
{
    protected $assetExtension;
    
    public function setUp() :void
    {
        $extension = new AssetsExtension();
        $this->assetExtension = $extension;
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/../TestClass/TestConfig.php'));
    }

    public function testCss()
    {
        $assetsPath = Config::getInstance()->get('assetsPath');
        $result = $this->assetExtension->css('test');
        $expected = '<link rel="stylesheet" type="text/css" href="' . $assetsPath .'css/test.css">';
        $this->assertEquals($expected, $result);
        $result = $this->assetExtension->css(['test', 'test2']);
        $this->assertSTringContainsString('<link rel="stylesheet" type="text/css" href="' . $assetsPath .'css/test.css">', $result);
        $this->assertSTringContainsString('<link rel="stylesheet" type="text/css" href="' . $assetsPath .'css/test2.css">', $result);
    }

    public function testJs()
    {
        $assetsPath = Config::getInstance()->get('assetsPath');
        $result = $this->assetExtension->js('test');
        $expected = '<script src="' . $assetsPath .'js/test.js"></script>';
        $this->assertEquals($expected, $result);
        $result = $this->assetExtension->js(['test', 'test2']);
        $this->assertSTringContainsString('<script src="' . $assetsPath .'js/test.js"></script>', $result);
        $this->assertSTringContainsString('<script src="' . $assetsPath .'js/test2.js"></script>', $result);
    }
}
