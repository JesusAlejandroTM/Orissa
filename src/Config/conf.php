<?php

    namespace App\Code\Config;

    // Class configuration pour se connecter à la BDD
    // Test
    class Conf
    {
        /**
         * @var int $sessionDuration the duration of a session in seconds
         */
        public static int $sessionDuration = 6000;

        /**
         * @var array|string[] $database the database connection information
         */
        static private array $database = array(
            'hostname' => 'localhost',
            'database' => 'starfish',
            'login' => 'root',
            'password' => ''
        );

        /**
         * @var array|string[] $apiUrls the API connection information
         */
        static private array $apiUrls = array(
            'apiHost' => 'https://taxref.mnhn.fr',
            'apiBasePath' => '/api'
        );

        /**
         * @var string $baseUrl the base URL of the application
         */
        static private string $baseUrl = 'http://localhost/Orissa';


        /**
         * Get the base URL of the taxref website
         * @return string
         */
        public static function getBaseUrl(): string
        {
            return self::$baseUrl;
        }

        /**
         * Get the URL of the taxref API
         * @return string
         */
        static public function getApiBasePath(): string
        {
            return static::$apiUrls['apiHost'] . static::$apiUrls['apiBasePath'];
        }

        /**
         * Get the hostname of the database
         * @return string the hostname of the database
         */
        static public function getHostname(): string
        {
            return static::$database['hostname'];
        }

        /**
         * Get the name of the database
         * @return string the name of the database
         */
        static public function getDatabase(): string
        {
            return static::$database['database'];
        }

        /**
         * Get the login of the database
         * @return string the login of the database
         */
        static public function getLogin(): string
        {
            return static::$database['login'];
        }

        /**
         * Get the password of the database
         * @return string the password of the database
         */
        static public function getPassword(): string
        {
            return static::$database['password'];
        }
    }
