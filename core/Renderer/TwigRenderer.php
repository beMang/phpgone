<?php
/**
 * Fichier de la classe TwigRenderer
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

class TwigRenderer extends ApplicationComponent implements RendererInterface
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
     * @example $render->addVar('title', 'Ceci est un titre'); Dans la vue cela pourra être utilisé : {{ title }}
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
        $loaderTwig = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/app/views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => false
        ]);
        //Ajout des extensions
        foreach ($this->getApp()->getConfig()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension);
        }
        return $twig->render($this->contentFile, $this->vars);
    }

    public function renderWithTwigCache($directory = null)
    {
        if (is_null($directory)) {
            $dir = __DIR__ . '../../../../../../tmp/cache/twig/';
        } else {
            $dir = $directory;
        }
        $loaderTwig = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] . '/app/views/');
        $twig = new \Twig_Environment($loaderTwig, [
            'cache' => $dir
        ]);
        //Ajout des extensions
        foreach ($this->getApp()->getCongig()->get('TwigExtensions') as $extension) {
            $twig->addExtension(new $extension);
        }
        return $twig->render($this->contentFile, $this->vars);
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
