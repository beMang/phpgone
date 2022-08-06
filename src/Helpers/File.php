<?php

namespace phpGone\Helpers;

use RuntimeException;

class File
{
    /**
     * Permet de nettoyer un dossier particulier
     *
     * @param string $dir_to_clean
     * @return bool succès
     */
    public static function clearDirectory(string $dir_to_clean): bool
    {
        $sub = array_diff(scandir($dir_to_clean), ['.', '..']);
        foreach ($sub as $value) {
            if (is_dir($dir_to_clean . '/' . $value)) {
                File::clearDirectory($dir_to_clean . '/' . $value);
                rmdir($dir_to_clean . '/' . $value);
            } elseif (is_file($dir_to_clean . '/' . $value)) {
                unlink($dir_to_clean . '/' . $value);
            } else {
                throw new RuntimeException('Erreur pour le nettoyage du dossier ' . $dir_to_clean);
                
            }
        }
        return true;
    }
}