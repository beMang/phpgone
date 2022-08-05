<?php

namespace phpGone\Helpers;

use bemang\Config;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;
use ReflectionClass;
use Stringable;

/**
 * Class Logger
 * Permet d'écrire dans les fichiers de logs
 */
class Logger extends AbstractLogger
{
    /**
     * @param $level
     * @param string|Stringable $message
     * @param array $context
     * @return void
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $reflection = new ReflectionClass(LogLevel::class);
        $cst = $reflection->getConstants();
        $urlHelper = new Url();
        echo('hey');
        if (in_array($level, $cst)) {
            $text = date('d/m/y - G:i:s') . ' - ' . $level . ' - Message : ' . $message . "\n";
            echo(file_put_contents($urlHelper->getTmpPath('log') . 'phpgonelog.log', $text, FILE_APPEND));
            echo('bonjour');
        } else {
            throw new InvalidArgumentException('Le niveau du log est invalide');
        }
    }
}
