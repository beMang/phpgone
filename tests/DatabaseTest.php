<?php

namespace Test;

use phpGone\Database\DBManager;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    protected $manager;

    public function setUp()
    {
    }

    public function testPDO()
    {
        new \PDO('mysql:host=localhost', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
}
