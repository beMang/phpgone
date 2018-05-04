<?php

namespace phpGone\Database;

class Query
{
    protected $tableName;
    protected $dbManager;

    public function __construct($tableName)
    {
        $this->setTableName($tableName);
        $this->setDBManager(DBManager::getInstance());
    }

    private function setTableName($tableName)
    {
        if (class_exists($tableName)) {
            $this->tableName = $tableName;
        } else {
            throw new \InvalidArgumentException('La table' . $tableName . 'est inexistante');
        }
    }

    public function setDBManager(DBManager $manager)
    {
        $this->dbManager = $manager;
    }
}
