<?php
/**
 * Fichier de la classe ErrorController
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Error;

use bemang\Config;
use phpGone\Core\Application;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ErrorController
 * Controller pour gérer les erreurs
 */
class ErrorController extends \phpGone\Core\BackController
{
    /**
     * Constructeur du controller
     *
     * @param Application $app Application à faire passer au composant (ApplicationComponent)
     * @param string $module Module à traiter
     * @param string $action Action à executer
     */
    public function __construct($action)
    {
        parent::__construct($action);
    }

    /**
     * Execution de l'action pour faire le rendu adéquat
     *
     * @return void
     */
    public function show()
    {
        $this->getRenderer()->twigRender(Config::getInstance()->get('viewError404'), []);
    }
}
