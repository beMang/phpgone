<?php

namespace Test;

use phpGone\Database\Query;
use phpGone\Database\DBManager;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    protected $manager;
    protected $pdo;

    public function setUp()
    {
        $pdo = new \PDO('mysql:host=localhost', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        $pdo->prepare('CREATE DATABASE test DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci')->execute();
        unset($pdo);
        $pdo = new \PDO('mysql:host=localhost;dbname=test', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        $pdo->prepare('CREATE TABLE user_test (
                        id int NOT NULL AUTO_INCREMENT,
                        name varchar(255),
                        surname varchar(255),
                        pseudo varchar(48),
                        PRIMARY KEY (id)
                    )')->execute();
        $pdo->prepare('CREATE TABLE test2 (
                        id int NOT NULL AUTO_INCREMENT,
                        value int,
                        content varchar(255),
                        user_id varchar(200),
                        PRIMARY KEY (id)
                    )')->execute();
        $this->pdo = $pdo;
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $manager = DBManager::getInstance($app);
        $manager->addDatabase('base', 'mysql:host=localhost;dbname=test', 'root', '');
        $this->manager = $manager;
    }

    protected function tearDown()
    {
        $this->pdo->prepare('DROP DATABASE `test`')->execute();
    }

    public function testEmptyInstance()
    {
        $query = new Query('user_test', 'base');
        $instance = $query->getEmptyInstance();
        $this->assertInstanceOf('base_user_test', $instance);
    }
}
