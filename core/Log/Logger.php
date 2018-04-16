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

/**
 * Class Logger
 * Permet d'écrire dans les fichiers de logs
 */
class Logger implements \Psr\Log\LoggerInterface
{
    /**
     * Système inutilisable
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Des mesures doivent être prises immédiatement
     *
     * Example: Base de donnée invalide, etc.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Conditions critiques
     *
     * Example: Composant d'applications invalides, erreurs inattendues
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Erreurs d'execution qui ne nécessitent pas d'action immédiate mais devraient être surveillées
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Occurrences exceptionnelles qui ne sont pas des erreurs.
     *
     * Exemple : Utilisation d'API dépreciée, mauvais usage d'API, chose indésirable
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Evenements normaux mais significatifs
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Informations
     *
     * Example: Requete sql, connexion d'utilisateur,...
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Information détaillées bugs
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Envoie un log
     *
     * @param string $loglevel Niveau d'importance du log
     * @param string $message Message à faire passer
     * @param array $context Contexte du log
     * @return void
     */
    public function log($loglevel, $message, array $context = [])
    {
        switch ($loglevel) {
            case LogLevel::EMERGENCY:
                $text = date('d/m/y - G:i:s') . ' - EMERGENCY !!!! : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ALERT:
                $text = date('d/m/y - G:i:s') . ' - ALERT !! : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::CRITICAL:
                $text = date('d/m/y - G:i:s') . ' - CRITICAL ! : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::ERROR:
                $text = date('d/m/y - G:i:s') . ' - Error : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::WARNING:
                $text = date('d/m/y - G:i:s') . ' - Warning : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::NOTICE:
                $text = date('d/m/y - G:i:s') . ' - Notice : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::INFO:
                $text = date('d/m/y - G:i:s') . ' - Info : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;

            case LogLevel::DEBUG:
                $text = date('d/m/y - G:i:s') . ' - Debug : ' . $message . "\n";
                file_put_contents(__DIR__ . '/../../../../../tmp/log/phpgonelog.log', $text, FILE_APPEND);
                break;
        }
    }
}
