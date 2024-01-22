<?php

    namespace App\Code\Model\API;

    class TaxaHabitatIdentifier
    {
        private const HabitatData = [
            "null",
            [
                "name" => "Marin", "desc" => "Espèces vivant uniquement en milieu marin."
            ],
            [
                "name" => "Eau douce", "desc" => "Espèces vivant uniquement en milieu d’eau douce."
            ],
            [
                "name" => "Terrestre", "desc" => "Espèces vivant uniquement en milieu terrestre."
            ],
            [
                "name" => "Marin et eau douce",
                    "desc" => "Espèces effectuant une partie de leur cycle de vie en eau douce
                     et l’autre partie en mer (espèces diadromes, amphidromes, anadromes ou catadromes)."
            ],
            [
                "name" => "Marin et terrestre", "desc" =>
                    "Espèces effectuant une partie de leur cycle de vie en mer et
                     l’autre partie à terre (pinnipèdes, tortues ou oiseaux marins par exemple)"
            ],
            [
                "name" => "Eau saumâtre", "desc" => "Espèces vivant exclusivement en eau saumâtre."
            ],
            [
                "name" => "Continental (terrestre et/ou eau douce)",
                    "desc" => "Espèces continentales (non marines) dont on ne sait pas
                     si elles sont terrestres et/ou d’eau douce (taxons provenant de Fauna Europaea)"
            ],
            [
                "name" => "Continental (terrestre et eau douce)",
                    "desc" => "Espèces terrestres effectuant une partie de leur cycle en eau douce
                     (odonates par exemple), ou fortement liées au milieu aquatique (loutre par exemple)."
            ],
        ];

        public static function GetNameHabitat($idHabitat): string
        {
            return self::HabitatData[$idHabitat]['name'] ?? "Inconnue";
        }

        public static function GetDescriptionHabitat($idHabitat): string
        {
            return self::HabitatData[$idHabitat]['desc'] ?? "Inconnue";
        }
    }