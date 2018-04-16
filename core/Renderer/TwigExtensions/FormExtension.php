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

/**
 * Class FormExtension
 * Facilite la génération de formulaire
 */
class FormExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('field', [$this, 'field'])
        ];
    }

    public function field($key, $value, $label, array $option = [])
    {
        //TO DO !!
    }
}
