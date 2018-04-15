<?php
/**
 * Fichier de la classe Session
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 */
namespace phpGone\Session;

/**
 * Class Session
 * Gestion des sessions simples (pour l'utiliser le session_start() doit être bien démarré)
 */
class Session
{
    use FlashTrait;
    /**
     * Ajoute un attribut à la session
     *
     * @param string $key Clé de l'attribut
     * @param string $value Valeur de l'attribut
     * @return void
     */
    public function addAttr($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Modifie un attribut de la session
     *
     * @param string $key Clé de l'attribut à modifier
     * @param string $value Valeur de l'attribut à modifier
     * @return bool succès de l'opération
     */
    public function updateAttr($key, $value)
    {
        if (isset($_SESSION[$key])) {
            $_SESSION[$key] = $value;
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Récupère la valeur d'un attribut
     *
     * @param string $key Clé de l'attribut à modifier
     * @return bool/string Valeur de l'attribut ou false si erreur
     */
    public function getAttr($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Supprime un attribut
     *
     * @param string $key Clé de l'attribut à supprimer
     * @return void
     */
    public function removeAttr($attr) :void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Vérifie si un attribut existe
     *
     * @param string $key Clé de l'attribut à vérifier
     * @return boolean Résulatat de la vérification
     */
    public function hasAttr($key)
    {
        if (isset($_SESSION[$key])) {
            return true;
        } else {
            return false;
        }
    }
}
