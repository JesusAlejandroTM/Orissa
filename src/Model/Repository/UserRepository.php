<?php

    namespace App\Web\Model\Repository;

    use App\Web\Model\DataObject\User;
    use PDO;

    class UserRepository
    {

        public static function selectWithId(int $id) : User
        {
            $sql = "SELECT * FROM user WHERE id_user = :id_userTag";
            $values = array("id_userTag" => $id);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            return self::Construire($userData);
        }
        public static function Construire(array $userArray): User
        {
            return new User(...array_values($userArray));
        }
    }