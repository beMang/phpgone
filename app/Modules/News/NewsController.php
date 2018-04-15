<?php

namespace app\Modules\News;

use phpGone\Core\BackController;
use Psr\Http\Message\ServerRequestInterface;

class NewsController extends BackController
{
    public function executeIndex(ServerRequestInterface $request)
    {
        $modele = new NewsModele($this->getApp()->getContainer());
        $list = $modele->getList();
        $this->getMainRender()->addVar('news', $list);
    }

    public function executeUnique()
    {
        $modele = new NewsModele($this->getApp()->getContainer());
        $text = preg_replace('#(%20)#', ' ', $_GET['slug']);
        $news = $modele->getUnique($text);
        $this->getMainRender()->addVar('news', $news);
    }
}
