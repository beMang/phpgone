<?php
/**
 * Fichier de l'interface RendererInterface
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Renderer;

/**
 * Interface RendererInterface
 * Interface à implémenter pour créer un rendu personalisé
 */
interface RendererInterface
{

    /**
     * Ajoute une valeur qui pourra être utilisée dans la vue
     *
     * @example $render->addVar('title', 'Ceci est un titre'); Dans la vue cela pourra être utilisé : <?= $title ?>
     *
     * @param string $var Clé de la variable
     * @param string $value Valeur de la variable
     * @return void
     */
    public function addVar($var, $value);

    /**
     * Renvoie le code html généré (Sans être écrit)
     *
     * @return string code html généré
     */
    public function render();

    /**
     * Précise le chemin du fichier de la vue
     *
     * @param string $path Chemin du fichier de la vue
     * @return void
     */
    public function setContentFile($path);
}
