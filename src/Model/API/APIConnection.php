<?php

    namespace App\Web\Model\API;

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

        // Get the URL of the API
        public static function getApiURL(): string
        {
            return static::getInstance()->apiURL;
        }

        // Singleton instance
        private static function getInstance(): APIConnection
        {
            //Check that instance is null
            if (is_null(static::$instance))
                // Création d'une connexion
                static::$instance = new APIConnection();
            return static::$instance;
        }

        // Methods to call data from the API
        public static function obtenirGroupeOperationnelId(int $id)
        {
            try {
                // Request to the API
                $apiUrl = static::getApiURL() . "/operationalGroups/$id";
                $response = file_get_contents($apiUrl);

                // Check that we got a response
                if (!$response) {
                    throw new InvalidArgumentException("Le taxon avec id : $id n'existe pas.");
                } // Decode the JSON string from the API response
                else {
                    $data = json_decode($response, true);

                    if ($data == null || isset($data['_embedded'])) throw new Exception("Erreur avec le décodage de votre requête");
                }
                // Return the taxa object
                return $data;
            } catch (InvalidArgumentException|Exception $e) {
                return $e->getMessage();
            }
        }
    }
