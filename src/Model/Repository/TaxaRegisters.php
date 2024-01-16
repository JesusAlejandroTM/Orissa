<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use Exception;
    use PDO;

    class TaxaRegisters
    {
        /**
         * Register a taxa to a user to the database through their IDs
         * @param int $taxaId
         * @return void
         */
        public static function RegisterTaxa(int $taxaId): void
        {
            try {
                $id = UserSession::getLoggedId();
                $sql = "INSERT INTO register (id_registerer, id_registered) VALUES (:idUserTag, :idTaxaTag)";
                $values = ["idUserTag" => $id, "idTaxaTag" => $taxaId];
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("Erreur enregistrement $taxaId");
                }
            } catch (Exception $e) {
                FlashMessages::add("warning", "Erreur enregistrement");
                header("Location: /Orissa/Home");
            } finally {
                $pdoStatement = null;
            }
        }

        /**
         * Check if logged-in user has registered a taxa through their IDs
         * @param int $taxaId
         * @return bool
         */
        public static function CheckRegisteredTaxa(int $taxaId) : bool
        {
            try {
                $id = UserSession::getLoggedId();
                $sql = "SELECT COUNT(*) > 0 AS data_exists FROM register 
                    WHERE id_registerer = :idUserTag AND id_registered = :idTaxaTag;";
                $values = ["idUserTag" => $id, "idTaxaTag" => $taxaId];

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                $data = $pdoStatement->fetch(PDO::FETCH_NUM);
                if ($data[0] > 0) return true;
                else return false;
            } catch (Exception $e) {
                FlashMessages::add("warning", "Erreur vérification");
                header("Location: /Orissa/Home");
                return false;
            } finally {
                $pdoStatement = null;
            }
        }

        /**
         * Get all registered taxas of user from database
         * @return array|null array of taxa ids or null if none
         */
        public static function SelectRegisteredTaxas() : array|null
        {
            try {
                $id = UserSession::getLoggedId();
                $sql = "SELECT id_registered FROM register WHERE id_registerer = :idUserTag";
                $values = ["idUserTag" => $id];

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                return $pdoStatement->fetchAll(PDO::FETCH_NUM);
            } catch (Exception $e) {
                FlashMessages::add("warning", "Erreur sélection");
                header("Location: /Orissa/Home");
                return null;
            } finally {
                $pdoStatement = null;
            }
        }
    }