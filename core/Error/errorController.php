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
use phpGone\Renderer\Renderer;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ErrorController
 * Controller pour gérer les erreurs
 */
class ErrorController extends \phpGone\Core\BackController
{
    /**
     * Execution de l'action pour faire le rendu adéquat
     *
     * @return void
     */
    public function show()
    {
        Renderer::twigRender(Config::getInstance()->get('viewError404'), []);
    }
}
