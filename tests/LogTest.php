<?php
namespace Test;

use Psr\Log\LogLevel;

class LogTest extends \PHPUnit\Framework\TestCase{
    public function __destruct(){
        if(file_exists(__DIR__ . '/../tmp/log/phpgonelog.log')){
            unlink(__DIR__ . '/../tmp/log/phpgonelog.log');
        }
    }
    public function getLogger(){
        return new \phpGone\Log\Logger();
    }

    public function getLevels(){
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

    public function getLastLog(){
        $tab = file(__DIR__ . '/../tmp/log/phpgonelog.log');
        return $der_ligne = $tab[count($tab)-1];
    }

    public function testAllLog(){
        foreach($this->getLevels() as $level){
            $message = 'Test : ' . $level;
            $this->getLogger()->$level($message, []);
            $this->assertContains($message, $this->getLastLog());
        }
    }

    public function testLogWithFalseLevel(){
        $this->expectExceptionMessage('Le niveau du log est invalide');
        $this->getLogger()->log('fdsqlkmj', 'jkmfjml', []);
    }
}