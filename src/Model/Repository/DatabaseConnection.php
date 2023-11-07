<?php

    namespace App\Code\Model\Repository;

    use App\Code\Config\Conf;
    use PDO;

// Class Model gérant les récupérations et traitement d'information
    class DatabaseConnection
    {
        /**Instance attribut allowing for singleton pattern
         * @var DatabaseConnection|null
         */
        private static DatabaseConnection|null $instance = null;

        /**PDO attribute to access the database
         * @var PDO
         */
        private PDO $pdo;

        /**Get the PDO of our database using getInstance
         * @return PDO
         */
        public static function getPdo(): PDO
        {
            return static::getInstance()->pdo;
        }

        /**Creates a connexion to the database in a singleton pattern
         * @return DatabaseConnection
         */
        private static function getInstance(): DatabaseConnection
        {
            // Check that instance is null
            if (is_null(static::$instance))
                // Create a connexion
                static::$instance = new DatabaseConnection();
            return static::$instance;
        }


        /**Constructor using static methods from Conf.php
         * These methods access to the necessary information to create a connexion to the
         * database. This method also configures our PDO attributes.
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
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
    }