<?php

namespace phpGone\TwigExtensions;

use bemang\ConfigException;
use bemang\InvalidArgumentExceptionConfig;
use Exception;
use phpGone\Helpers\Url;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Extension twig pour ajouter des assets facilement
 */
class AssetsExtension extends AbstractExtension
{
    /**
     * @var Url
     */
    protected Url $urlHelperInstance;

    /**
     *
     */
    public function __construct()
    {
        $this->urlHelperInstance = new Url();
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('css', [$this, 'css'], ['is_safe' => ['html']]),
            new TwigFunction('js', [$this, 'js'], ['is_safe' => ['html']])
        ];
    }

    /**
     * @param $nameFile
     * @return string
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     */
    public function css($nameFile): string
    {
        if (is_string($nameFile)) {
            return '<link rel="stylesheet" type="text/css" href="' .
                $this->urlHelperInstance->getPublicPath() .
                'css/' . $nameFile . '.css">';
        } elseif (is_array($nameFile)) {
            $result = '';
            foreach ($nameFile as $file) {
                $result = $result . '
                <link rel="stylesheet" type="text/css" href="' .
                    $this->urlHelperInstance->getPublicPath() . 'css/' .
                    $file . '.css">';
            }
            return $result;
        } else {
            throw new Exception("Erreur dans le choix des fichiers css");
        }
    }

    /**
     * @param $nameFile
     * @return string
     * @throws ConfigException
     * @throws InvalidArgumentExceptionConfig
     * @throws Exception
     */
    public function js($nameFile): string
    {
        if (is_string($nameFile)) {
            return '<script src="' .
                $this->urlHelperInstance->getPublicPath() .
                'js/' . $nameFile . '.js"></script>';
        } elseif (is_array($nameFile)) {
            $result = '';
            foreach ($nameFile as $file) {
                $result = $result . '
                <script src="' .
                    $this->urlHelperInstance->getPublicPath() .
                    'js/' . $file . '.js"></script>';
            }
            return $result;
        } else {
            throw new Exception("Erreur dans le choix des fichiers css");
        }
    }
}
