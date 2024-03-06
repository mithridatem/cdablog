<?php

namespace App\Service;

class UtilsService
{
    /**
     * Fonction qui va nettoyer la chaine en entrée
     * 
     * @param string $value chaine à nettoyer
     * @return string retourne la chaine néttoyée
     */
    public static function cleanInput(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_NOQUOTES);
    }
}
