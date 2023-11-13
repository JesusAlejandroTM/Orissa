<?php

    namespace App\Code\Model\API;

    use App\Code\Config\Conf;
    use InvalidArgumentException;
    use Exception;

    /**
     * APIConnection's task is to assure a singleton pattern, allowing
     * for only one connection to the TaxRef API per user to avoid potential conflicts
     * between different connections on a single user.
     * Use the method GetApiURL to send requests to the API using this pattern.
     */
    class APIConnection
    {
        /**
         * Static instance of APIConnection to avoid duplicates
         * @var APIConnection|null
         */

        private static APIConnection|null $instance = null;
        /**
         * URL of TaxRef API, used for sending requests
         * @var string
         */
        private string $apiURL;

        /**
         * Constructor for creating an APIConnection instance.
         */
        public function __construct()
        {
            $this->apiURL = Conf::getApiBasePath();
        }


        /**
         * APIConnection URL's getter, which allows to get a single instance
         * of the class using the GetInstance method.
         * @return string
         */
        public static function GetApiURL(): string
        {
            return static::GetInstance()->apiURL;
        }


        /**
         * GetInstance checks if there is an already existing instance of the API
         * in the $instance attribute. If it doesn't exist, it's created, else it will
         * be returned, preventing duplicate instances.
         * @return APIConnection
         */
        private static function GetInstance(): APIConnection
        {
            // Vérifie que instance est nul
            if (is_null(static::$instance))
                // Création d'une connexion
                static::$instance = new APIConnection();
            return static::$instance;
        }

        /**
         * Show current API model version used from TaxRef
         * @return string
         */
        public function __toString(): string
        {
            return "Modèle API utilise l'URL de TaxRef : " . $this->apiURL;
        }
    }
