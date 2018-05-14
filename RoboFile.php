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
        
    }
}
