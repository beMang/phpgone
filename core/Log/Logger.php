<?php

namespace phpGone\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

/**
 * Class Logger
 * Permet d'écrire dans les fichiers de logs
 */
class Logger extends AbstractLogger
{
    public function log($loglevel, $message, array $context = [])
    {
        switch ($loglevel) {
            case LogLevel::EMERGENCY:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ALERT:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::CRITICAL:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ERROR:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::WARNING:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::NOTICE:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::INFO:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::DEBUG:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . ' - Message : ' . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;
            default:
                throw new InvalidArgumentException('Le niveau du log est invalide');
            break;
        }
    }
}
