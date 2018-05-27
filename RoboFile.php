<?php

class RoboFile extends \Robo\Tasks
{
    public function clearlog()
    {
        $this->taskWriteToFile('tmp/log/phpgonelog.log')
        ->append(false)
        ->run();
    }

    public function clearCache()
    {
        $this->_cleanDir('app/cache/twig');
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
