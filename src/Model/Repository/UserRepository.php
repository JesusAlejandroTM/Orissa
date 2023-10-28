<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\PasswordManager;
    use App\Code\Model\DataObject\User;
    use LogicException;
    use PDO;
    use PDOException;

    class UserRepository
    {

        public static function selectWithId(int $id) : ?User
        {
            try {

                $sql = "SELECT id_user, mail, username, password, birthDate, role FROM user WHERE id_user = :id_userTag";
                $values = array("id_userTag" => $id);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() < 1) {
                    throw new LogicException("Erreur durant l'enregistrement");
                }
                $userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return self::Construire($userData);
            } catch (LogicException|PDOException $e) {
                echo $e->getMessage();
                return null;
            }
        }

        public static function selectWithUsername(string $username) : ?User
        {
            try {
                $sql = "SELECT id_user, mail, username, password, birthDate, role FROM user WHERE username = :usernameTag";
                $values = array("usernameTag" => $username);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() < 1) {
                    throw new LogicException("Erreur durant l'enregistrement");
                }
                $userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return self::Construire($userData);
            } catch (LogicException|PDOException $e) {
                echo $e->getMessage();
                return null;
            }
        }

        public static function Construire(?array $userArray) : ?User
        {
            if (is_null($userArray)) return null;
            else return new User(...array_values($userArray));
        }

        public static function construireAvecFormulaire(array $userArray) : User
        {
            $email = $userArray['email'];
            $username = $userArray['username'];
            $password = PasswordManager::hash($userArray['password']);
            $birthdate = $userArray['birthdate'];
            return new User(null, $email, $username, $password, $birthdate);
        }

        public static function sauvegarder(User $user) : bool {
            try{
                $sql = "INSERT INTO user (id_user, mail, username, password, birthDate)
                    VALUES (:idTag, :mailTag, :usernameTag, :passwordTag, :birthDateTag)";
                $values = array(
                    "idTag" => $user->getId(),
                    "mailTag" => $user->getMail(),
                    "usernameTag" => $user->getUsername(),
                    "passwordTag" => $user->getHashedPassword(),
                    "birthDateTag" => $user->getBirthDateString(),
                );
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() < 1){
                    throw new LogicException("Erreur durant l'enregistrement");
                }
            } catch (LogicException|PDOException $e) {
               echo $e->getMessage();
               return false;
            }
            return true;
        }
    }