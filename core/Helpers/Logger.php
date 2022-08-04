<?php

namespace phpGone\Helpers;

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
        if (in_array($level, $cst)) {
            $text = date('d/m/y - G:i:s') . ' - ' . $level . ' - Message : ' . $message . "\n";
            file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
        } else {
            throw new InvalidArgumentException('Le niveau du log est invalide');
        }
    }
}
