<?php
/**
 * Fichier de la classe Logger
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Log;

use Psr\Log\LogLevel;

/**
 * Class Logger
 * Permet d'écrire dans les fichiers de logs
 */
class Logger extends \Psr\Log\AbstractLogger
{
    static protected $loggerInstance = null;

    public static function getInstance()
    {
        if (is_null(Logger::$loggerInstance)) {
            Logger::$loggerInstance = new \phpGone\Log\Logger();
        }
        return Logger::$loggerInstance;
    }

    /**
     * Envoie un log
     *
     * @param string $loglevel Niveau d'importance du log
     * @param string $message Message à faire passer
     * @param array $context Contexte du log
     * @return void
     */
    public static function doLog($loglevel, $message, array $context = [])
    {
        Logger::getInstance()->log($loglevel, $message, $context);
    }

    public function log($loglevel, $message, array $context = [])
    {
        switch ($loglevel) {
            case LogLevel::EMERGENCY:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ALERT:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::CRITICAL:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ERROR:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::WARNING:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::NOTICE:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::INFO:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::DEBUG:
                $text = date('d/m/y - G:i:s') . ' - ' . $loglevel . $message . "\n";
                file_put_contents(dirname(__FILE__) . '/../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;
            default:
                throw new \Psr\Log\InvalidArgumentException('Le niveau du log est invalide');
            break;
        }
    }
}
