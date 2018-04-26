<?php
/**
 * Fichier de configuration de base du framework (obligatoire pour le bon fonctionnement)
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */

return[
    'TwigExtensions' => [
        phpGone\Renderer\TwigExtensions\UrlExtension::class
    ]
];
