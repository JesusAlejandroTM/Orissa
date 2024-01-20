<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use Exception;
    use PDOException;

    class LibraryTaxaManager
    {
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
    }