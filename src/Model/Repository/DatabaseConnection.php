<?php

    namespace App\Web\Model\Repository;

    use App\Web\Config\Conf;
    use PDO;

// Class Model gérant les récupérations et traitement d'information
    class DatabaseConnection
    {
        // Attribut statique permettant une seule connexion à la BDD
        private static DatabaseConnection|null $instance = null;


        // Attribut PDO afin d'accéder à la BDD à partir de celle-ci
        private PDO $pdo;

        // Getter PDO en utilisant getInstance()
        public static function getPdo(): PDO
        {
            return static::getInstance()->pdo;
        }

        // Méthode créant une connexion à la BDD et assurant une seule instance de connexion
        private static function getInstance(): DatabaseConnection
        {
            // Vérifie que instance est nul
            if (is_null(static::$instance))
                // Création d'une connexion
                static::$instance = new DatabaseConnection();
            return static::$instance;
        }

        /*
        Constructeur utilisant les méthodes statiques de Conf.php
        Ses méthodes accèdent aux informations nécessaire pour créer une connexion à la BDD
        Enfin, notre attribut PDO contiendra notre connexion et assure la bonne configuration
        */
        public function __construct()
        {
            // Accès aux informations
            $hostname = Conf::getHostname();
            $databaseName = Conf::getDatabase();
            $login = Conf::getLogin();
            $password = Conf::getPassword();

            // Création du PDO
            $this->pdo = new PDO(
                "mysql:host=$hostname;dbname=$databaseName",
                $login,
                $password,
                // Configuration du PDO
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }