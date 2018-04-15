<?php
/**
 * Fichier de la classe PhpRenderer
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Renderer;

use phpGone\Core\Application;
use phpGone\Core\ApplicationComponent;

/**
 * Class PhpRenderer
 * Permet de rendre du code html avec une vue de base et des variables
 */
class PhpRenderer extends ApplicationComponent implements RendererInterface
{

    /**
     * Contient le chemin du fichier de la vue
     *
     * @var string
     */
    protected $contentFile;

    /**
     * Contient les différentes variables à utiliser pour la vue
     *
     * @var array[string]
     */
    protected $vars = [];

    /**
     * Constructeur de application component
     *
     * @param Application $app Application du composant
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Ajoute une valeur qui pourra être utilisée dans la vue
     *
     * @example $render->addVar('title', 'Ceci est un titre'); Dans la vue cela pourra être utilisé : <?= $title ?>
     *
     * @param string $var Clé de la variable
     * @param string $value Valeur de la variable
     * @return void
     */
    public function addVar($var, $value)
    {
        if (!is_string($var) || is_numeric($var) || empty($var)) {
            throw new \InvalidArgumentException('Le nom de la variable doit être une chaine de caractères valides');
        }
        $this->vars[$var] = $value;
    }

    /**
     * Renvoie le code html généré (Sans être écrit)
     *
     * @return string code html généré
     */
    public function render()
    {
        if (!file_exists($this->contentFile)) {
            throw new \RuntimeException('La vue spécifiée n\'existe pas');
        }

        extract($this->vars);

        ob_start();
        require $this->contentFile;
        $content = ob_get_clean();
        return $content;
    }

    /**
     * Précise le chemin du fichier de la vue
     *
     * @param string $path Chemin du fichier de la vue
     * @return void
     */
    public function setContentFile($file)
    {
        if (!is_string($file) || empty($file)) {
            throw new \InvalidArgumentException('La vue spécifiée est invalide');
        }
        $this->contentFile = $file;
    }
}
