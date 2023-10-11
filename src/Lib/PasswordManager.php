<?php

    namespace App\Web\Lib;

    use App\Web\Model\Repository\DatabaseConnection;
    use PDO;

    class PasswordManager
    {
        public static function verifyPassword(string $password, string $username) : bool
        {
            $sql = "SELECT password FROM user WHERE username = :usernameTag";
            $values = array('usernameTag' => $username);
            $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
            $pdoStatement->execute($values);
            $passwordHash = $pdoStatement->fetch(PDO::FETCH_ASSOC);
            return password_verify($password, $passwordHash['password']);
        }
    }