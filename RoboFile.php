<?php

class RoboFile extends \Robo\Tasks
{
    public function clearlog()
    {
        $this->taskWriteToFile('tmp/log/phpgonelog.log')
        ->append(false)
        ->run();
    }
}
