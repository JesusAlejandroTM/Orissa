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

        public function SelectWithLogin(string $login, $withID = false): User|string
        {
            try {
                if ($withID) {
                    $sql = 'SELECT ' . $this->GetSQLColumns() . ' FROM ' . $this->GetTableName() .
                        ' WHERE username = :usernameTag;';
                } else {
                    $sql = 'SELECT ' . $this->GetSQLColumnsWithoutPrimary() . ' FROM ' . $this->GetTableName() .
                        ' WHERE username = :usernameTag;';
                }

                $values = array(':usernameTag' => $login);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$login inexistant");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Build($data);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }
    }