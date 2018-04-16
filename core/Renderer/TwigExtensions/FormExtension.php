<?php
/**
 * Fichier de la classe FormExtension
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Renderer\TwigExtensions;

use phpGone\Renderer\TwigExtensions\BaseTwigExtension;

/**
 * @example Cette classe est un exemple (incomplet) d'une extension twig
 */
class FormExtension extends BaseTwigExtension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('field', [$this, 'field'])
        ];
    }

    public function field()
    {
        return $this->getConfig()->get('database.host');
    }
}
