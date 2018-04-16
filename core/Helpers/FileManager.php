<?php
/**
 * Fichier de la classe fileManager
 *
 * PHP Version 5
 *
 * @license MIT
 * @copyright 2017 Antonutti Adrien
 * @author Antonutti Adrien <antonuttiadrien@email.com>
 * @deprecated Inutilisable car importé depuis un autre projet
 */
namespace adriHelpers;

class FileManager extends \phpGone\Helpers\Helper
{
    const FICHIER_TROP_GROS = 0;
    const EXTENSION_INVALIDE = 1;
    const ERREUR_DE_TRANSFERT = 2;

    protected $dirImg;
    protected $maxSizeImg;

    public function moveImageUpload($fileNamePost, $fileName, $dossierDestination)
    {
        if ($_FILES[$fileNamePost]['error'] == 0) {
            if ($_FILES[$fileNamePost]['size'] < $this->$maxSizeImg) {
                $extensions_valides = array('.jpg', '.jpeg', '.png', '.gif');
                $extension = strtolower(strrchr($_FILES[$fileNamePost]['name'], '.'));
                if (in_array($extension, $extensions_valides)) {
                    $chemin = $dossierDestination;
                    $chemin .= $fileName;
                    $chemin .= $extension;
                    move_uploaded_file($_FILES[$fileNamePost]['tmp_name'], $chemin);
                } else {
                    return self::EXTENSION_INVALIDE;
                }
            } else {
                return self::FICHIER_TROP_GROS;
            }
        } else {
            return array(self::ERREUR_DE_TRANSFERT, $_FILES[$fileNamePost]['error']);
        }
    }

    public function moveFileUpload($fileNamePost, $fileName, $dossierDestination)
    {
    }

    public function removeFile($dossier, $fichier)
    {
    }
}
