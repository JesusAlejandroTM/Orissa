<?php

    namespace App\Code\Model\API;

    class RedListIdentifier
    {
        private const RedListAcronyms = [
            "EX" => "Éteint",
            "EW" => "Éteint dans la nature",
            "RE" => "En danger critique d'extinction",
            "CR" => "Éteint localement",
            "EN" => "En danger",
            "VU" => "Vulnérable",
            "LR" => "Risque plus faible",
            "NT" => "Quasi menacé",
            "LC" => "Préoccupation mineure",
            "DD" => "Données insuffisantes",
        ];

        /**
         * Get the description of a red list status from its acronym
         * @param $acronym string the acronym of the red list status
         * @return string the description of the red list status
         */
        public static function GetAcronymDescription($acronym): string
        {
            $cleanedAcronym = substr($acronym, 0, 2);
            return self::RedListAcronyms[$cleanedAcronym] ?? "Status inconnu";
        }
    }