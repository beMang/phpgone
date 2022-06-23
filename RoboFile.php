<?php

use Robo\Tasks;

class RoboFile extends Tasks
{
    public function clear($opts = ['c' => false, 'l' => false])
    {
        if ($opts['c'] !== false) {
            $this->_cleanDir('tmp/cache/twig');
            $this->_cleanDir('tmp/cache/phpgone');
        }
        if ($opts['l'] !== false) {
            $this->taskWriteToFile('tmp/log/phpgonelog.log')
            ->append(false)
            ->run();
        }
        if ($opts['l'] === false && $opts['c'] === false) {
            $this->_cleanDir('tmp/cache/twig');
            $this->_cleanDir('tmp/cache/phpgone');
            $this->taskWriteToFile('tmp/log/phpgonelog.log')
            ->append(false)
            ->run();
        }
    }

    public function createTmpDir()
    {
        $this->_mkdir('tmp');
        $this->_mkdir('tmp/log');
        $this->_mkdir('tmp/cache/twig');
        $this->_mkdir('tmp/cache/phpgone');
        $this->_touch('tmp/log/phpgonelog.log');
    }
}
