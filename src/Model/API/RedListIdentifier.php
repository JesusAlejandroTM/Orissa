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

        public static function GetAcronymDescription($acronym): string
        {
            $cleanedAcronym = substr($acronym, 0, 2);
            return self::RedListAcronyms[$cleanedAcronym] ?? "Status inconnu";
        }
    }