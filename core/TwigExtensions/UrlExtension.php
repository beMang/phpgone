<?php

namespace phpGone\TwigExtensions;

use Twig\TwigFunction;
use phpGone\Helpers\Url;
use Twig\Extension\AbstractExtension;

/**
 * Extension twig facilitant l'accès aux url
 */
class UrlExtension extends AbstractExtension
{
    protected Url $urlHelperInstance;

    public function __construct()
    {
        $this->urlHelperInstance = new Url();
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('tmpPath', [$this->urlHelperInstance, 'getTmpPath']),
            new TwigFunction('appPath', [$this->urlHelperInstance, 'getAppPath']),
            new TwigFunction('testsPath', [$this->urlHelperInstance, 'getTestsPath'])
        ];
    }
}
