<?php

    namespace App\Code\Model\API;

    use App\Code\Config\Conf;
    use InvalidArgumentException;
    use Exception;

    class APIConnection
    {
        private static APIConnection|null $instance = null;
        private string $apiURL;

        public function __construct()
        {
            $this->apiURL = Conf::getApiBasePath();
        }

        public function __toString(): string
        {
            return "Modèle API utilise l'URL de TaxRef : " . $this->apiURL;
        }

        // Obtenir l'URL de l'API pour les requêtes à venir sur l'API
        public static function getApiURL(): string
        {
            return static::getInstance()->apiURL;
        }

        // S'assurer qu'il n'y qu'une session de
        private static function getInstance(): APIConnection
        {
            // Vérifie que instance est nul
            if (is_null(static::$instance))
                // Création d'une connexion
                static::$instance = new APIConnection();
            return static::$instance;
        }

        // Méthodes faisant appel à l'API pour obtenir des données

        // Non utilisé
        public static function obtenirGroupeOperationnelId(int $id)
        {
            try {
                // Send request to API
                $apiUrl = static::getApiURL() . "/operationalGroups/$id";
                $reponse = file_get_contents($apiUrl);

                // Check for a response
                if (!$reponse) {
                    throw new InvalidArgumentException("Le taxon avec id : $id n'existe pas.");
                } // Decode the API response
                else {
                    $data = json_decode($reponse, true);

                    if ($data == null || isset($data['_embedded'])) throw new Exception("Erreur avec le décodage de votre requête");
                }
                // Retourner the
                return $data;
            } catch (InvalidArgumentException|Exception $e) {
                return $e->getMessage();
            }
        }
    }
