<?php

namespace Test;

use phpGone\Database\Query;
use phpGone\Database\DBManager;

class DatabaseTest extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass()
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
    }

    public static function tearDownAfterClass()
    {
        $pdo = new \PDO('mysql:host=localhost', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        $pdo->prepare('DROP DATABASE `test`')->execute();
    }

    /**
     * Test la configuration du manager et de l'ajout une base
     *
     * @doesNotPerformAssertions
     * @return  void
     */
    public function testConfigSystem()
    {
        $request = new \GuzzleHttp\Psr7\ServerRequest('GET', '/');
        $app = new \phpGone\Core\Application(__DIR__ . '/../app/config.php', $request);
        $manager = DBManager::getInstance($app);
        $manager->addDatabase('base', 'mysql:host=localhost;dbname=test', 'root', '');
    }

    public function testGetInvalidDatabase()
    {
        $this->expectExceptionMessage('La base de donnée est inexistante');
        $manager = DBManager::getInstance();
        $manager->getDatabase(uniqid());
    }

    public function testGetInvalidStringDatabase()
    {
        $this->expectExceptionMessage('L\'identifiant doit être une chaine de caractères');
        $manager = DBManager::getInstance();
        $manager->getDatabase(55454);
    }

    public function testDatabaseExist()
    {
        $manager = DBManager::getInstance();
        $this->assertTrue($manager->dataBaseExist('base'));
        $this->assertFalse($manager->dataBaseExist(uniqid()));
        $this->assertFalse($manager->dataBaseExist(545));
    }

    public function testEmptyInstance()
    {
        $query = new Query('user_test', 'base');
        $instance = $query->getEmptyInstance();
        $this->assertInstanceOf('base_user_test', $instance);
    }

    public function testInsert()
    {
        $query = new Query('user_test', 'base');
        $instance = $query->getEmptyInstance();
        $instance->name = 'Arnlold';
        $instance->surname = 'Pierre';
        $instance->pseudo = 'griuKu';
        $query->insert($instance);
        $instance->id = 1;
        $this->assertEquals($query->getLast(), $instance);
    }

    public function testUpdate()
    {
        $query = new Query('user_test', 'base');
        $instance = $query->getLast();
        $instance->name = 'Viktor';
        $instance->surname = 'Vladivostok';
        $instance->pseudo = uniqid();
        $query->update($instance);
        $this->assertEquals($query->getLast(), $instance);
    }
}
