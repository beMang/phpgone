<?php

namespace app\Modules\News;

class NewsModele
{
    protected $container;

    public function __construct(\DI\Container $container)
    {
        $this->container = $container;
    }

    public function getList()
    {
        $db = $this->container->get(\phpGone\Database\DatabasePDO::class);
        $q = $db->query('SELECT * FROM news ORDER BY id DESC');
        return $q->fetchAll();
    }

    public function getUnique($id)
    {
        $db = $this->container->get(\phpGone\Database\DatabasePDO::class);
        if (is_numeric($id)) {
            $q = $db->prepare('SELECT * FROM news WHERE id= ?');
            $q->execute([$id]);
            return $q->fetch();
        } elseif (is_string($id)) {
            $q = $db->prepare('SELECT * FROM news WHERE Titre= ?');
            $q->execute([$id]);
            return $q->fetch();
        } else {
            return false;
        }
    }
}
