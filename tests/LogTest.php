<?php

namespace tests;

use bemang\Config;
use GuzzleHttp\Psr7\ServerRequest;
use phpGone\Core\Application;
use Psr\Log\LogLevel;
use phpGone\Helpers\Url;
use phpGone\Helpers\Logger;
use PHPUnit\Framework\TestCase;

class LogTest extends TestCase
{
    protected Url $urlHelper;

    public function setUp(): void
    {
        $config = Config::getInstance();
        $config->define(require(__DIR__ . '/TestClass/TestConfig.php'));
        $this->urlHelper = new Url();
    }

    public function __destruct()
    {
        $filename = $this->urlHelper->getTmpPath('log') . 'phpgonelog.log';
        if (file_exists($filename)) {
            $handle = fopen($filename, 'r+');
            ftruncate($handle, 0);
            fclose($handle);
        }
        /**
        $app = new Application(Config::getInstance(),new ServerRequest('GET', 'test'));
        $app->clearTmpDir();
        */
    }

    public function getLogger()
    {
        return new Logger();
    }

    public function getLevels()
    {
        return array(
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG
        );
    }

    public function getLastLog()
    {
        $tab = file($this->urlHelper->getTmpPath('log') . 'phpgonelog.log');
        return $der_ligne = $tab[count($tab) - 1];
    }

    public function testAllLog()
    {
        foreach ($this->getLevels() as $level) {
            $message = 'Test : ' . $level;
            $this->getLogger()->$level($message, []);
            $this->assertSTringContainsString($message, $this->getLastLog());
        }
    }

    public function testLogWithFalseLevel()
    {
        $this->expectExceptionMessage('Le niveau du log est invalide');
        $this->getLogger()->log('fdsqlkmj', 'jkmfjml', []);
    }
}
