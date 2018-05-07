<?php

namespace phpGone\Database;

class DBManager extends \phpGone\Core\ApplicationComponent
{
    protected $pdoInstances = [];
    static protected $selfInstance = null;

    public function __construct(\phpGone\Core\Application $app)
    {
        parent::__construct($app);
        //$this->addDatabase(); Initialize default db in config
    }

    public static function getInstance($app = false)
    {
        if (is_null(DBManager::$selfInstance)) {
            DBManager::$selfInstance = new DBManager($app);
            return DBManager::$selfInstance;
        } else {
            return DBManager::$selfInstance;
        }
    }

    public function addDatabase($name, $hostAndDb = 'mysql:host=localhost;dbname=test', $user = 'root', $passwd = '')
    {
        $pdoInstance = new \PDO($hostAndDb, $user, $passwd, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdoInstance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->defineClasses($name, $pdoInstance);
        $this->pdoInstances [$name] = $pdoInstance;
    }

    public function getDatabase($name)
    {
        if (is_string($name)) {
            if (isset($this->pdoInstances[$name])) {
                return $this->pdoInstances[$name];
            } else {
                throw new \RuntimeException('La base de donnée est inexistante');
            }
        } else {
            throw new \InvalidArgumentException('L\'identifiant doit être une chaine de caractères');
        }
    }

    public function dataBaseExist($name)
    {
        if (is_string($name)) {
            if (isset($this->pdoInstances[$name])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function defineClasses($name, \PDO $pdoInstance)
    {
        $tables = $pdoInstance->query('SHOW TABLES')->fetchAll();
        foreach ($tables as $table) {
            $columns = $pdoInstance->query('SHOW COLUMNS FROM ' . $table[0])->fetchAll();
            $classcode = 'class ' . $name . '_' . $table[0] .' { ';
            foreach ($columns as $column) {
                $classcode .= 'public $' . $column['Field'] . ';';
            }
            $classcode .= "} ";
            eval($classcode);
        }
    }

    public function sql($sqlQuery, $params = false, $db = 1)
    {
        $db = $this->getDatabase($db);
        $query = $db->prepare($sqlQuery);
        try {
            if ($params == false) {
                $query->execute();
            } else {
                $query->execute($params);
            }
        } catch (PDOException $e) {
            throw new \Exception('Error sql');
        }
        return $query->fetchAll();
    }
}
