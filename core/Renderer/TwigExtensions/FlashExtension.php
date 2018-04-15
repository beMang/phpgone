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
class FlashExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('flash', [$this, 'flash'], ['is_safe' => ['html']])
        ];
    }

    public function flash()
    {
        if (isset($_SESSION['flash'])) {
            return '<section class="flash">' . $_SESSION['flash'] . '</section>';
        }
    }
}
