<?php

    namespace App\Web\Config;

    // Class configuration pour se connecter à la BDD
    // Test
    class Conf
    {
        // Attribut array $databases contenant les informations login à la BDD
        static private array $databases = array(
            'hostname' => 'localhost',
            'database' => 'lionscale',
            'login' => 'root',
            'password' => ''
        );

        static private array $apiUrls = array(
            'apiHost' => 'https://taxref.mnhn.fr',
            'apiBasePath' => '/api'
        );

        static public function getApiBasePath(): string
        {
            return static::$apiUrls['apiHost'] . static::$apiUrls['apiBasePath'];
        }

        // Fonctions getters statiques pour obtenirs les informations
        static public function getHostname(): string
        {
            return static::$databases['hostname'];
        }

        static public function getDatabase(): string
        {
            return static::$databases['database'];
        }

        static public function getLogin(): string
        {
            return static::$databases['login'];
        }

        static public function getPassword(): string
        {
            return static::$databases['password'];
        }
    }
