<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\PasswordManager;
    use App\Code\Model\DataObject\AbstractDataObject;
    use App\Code\Model\DataObject\User;
    use InvalidArgumentException;
    use PDO;

    class UserRepository extends AbstractRepository
    {
        protected function GetPrimaryKeyColumn(): string
        {
            return "id_user";
        }

        protected function GetTableName(): string
        {
            return "user";
        }


        protected function Build(array $arrayData): AbstractDataObject|bool
        {
            if (empty($arrayData)) return false;
            else return new User(...array_values($arrayData));
        }

        protected function GetColumnsNames(): array
        {
            return ["id_user", "mail", "username", "hashedPassword", "birthDate", "role"];
        }

        public static function BuildWithForm(array $userArray) : User
        {
            $email = $userArray['email'];
            $username = $userArray['username'];
            $password = PasswordManager::hash($userArray['password']);
            $birthdate = $userArray['birthdate'];
            return new User(null, $email, $username, $password, $birthdate);
        }

        public function SelectWithLogin(string $login): User|string
        {
            try {
                $sql = 'SELECT ' . $this->GetSQLColumns() . ' FROM ' . $this->GetTableName() .
                        ' WHERE username = :usernameTag;';

                $values = array(':usernameTag' => $login);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$login doesn't exist");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Build($data);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }

        private static function UserDataGetter(int $id, string $sql) {
            try {
                $values = array(':idTag' => $id);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$id doesn't exist");
                }
                return $pdoStatement->fetch(PDO::FETCH_ASSOC);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            } finally {
                $pdoStatement = null;
            }
        }

        public static function GetUserExtraInfo(int $id) : ?array
        {
            $sql = 'SELECT surname, name, phoneNumber, domain FROM user WHERE id_user = :idTag;';
            return self::UserDataGetter($id, $sql);
        }

    }