<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use Exception;
    use PDO;
    use PDOException;

    class LibraryTaxaManager
    {
        /**
         * Add a taxa to a library for a user in the database
         * @param int $idLib id of the library
         * @param int $idUser id of the user
         * @param int $idTaxa id of the taxa
         * @return bool|string true if success, error message otherwise
         */
        public static function addTaxaToLib(int $idLib, int $idUser, int $idTaxa): bool|string
        {
            $sql = "INSERT INTO librarylist (id_lib, id_user, id_taxa) VALUES (:idLibTag, :idUserTag, :idTaxaTag)";
            $values = ["idLibTag" => $idLib, "idUserTag" => $idUser, "idTaxaTag" => $idTaxa];

            try {
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("Erreur enregistrement $idTaxa dans $idLib par $idUser");
                }
            } catch (PDOException|Exception $e) {
                return $e->getMessage();
            } finally {
                $pdoStatement = null;
            }
            return true;
        }

        /**
         * Delete a taxa from a library for a user in the database
         * @param int $idLib id of the library
         * @param int $idTaxa id of the taxa
         * @return bool|string
         */
        public static function deleteTaxaFromLib(int $idLib, int $idTaxa): bool|string
        {
            $sql = "DELETE FROM librarylist WHERE id_lib = :idLibTag AND id_taxa = :idTaxaTag";
            $values = ["idLibTag" => $idLib, "idTaxaTag" => $idTaxa];
            try {
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("Erreur suppression $idTaxa dans $idLib");
                }
            } catch (PDOException|Exception $e) {
                return $e->getMessage();
            } finally {
                $pdoStatement = null;
            }
            return true;
        }

        /**
         * Select all the taxa from a library for a user in the database
         * @param int $idLib id of the library
         * @return array|string array of taxa ids if success, error message otherwise
         */
        public static function selectAllTaxaFromUserLib(int $idLib): array|string
        {
            $sql = "SELECT id_taxa FROM librarylist WHERE id_lib = :idLibTag";
            $values = ["idLibTag" => $idLib];

            try {
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("Pas de taxons enregistrés dans cette naturothèque");
                }
                $result = [];
                $data = $pdoStatement->fetchAll(PDO::FETCH_NUM);
                foreach ($data as $taxa)
                {
                    $result[] = $taxa[0];
                }
                return $result;
            } catch (PDOException|Exception $e) {
                return $e->getMessage();
            } finally {
                $pdoStatement = null;
            }
        }
    }