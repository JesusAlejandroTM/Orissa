<?php

    namespace App\Code\Model\Repository;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\PasswordManager;
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


        protected function Build(array $arrayData): User|bool
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
            return new User(null, $email, $username, $password, $birthdate, "User");
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

        public static function GetUserExtraInfo(int $id) : ?array
        {
            $sql = 'SELECT created_at, surname, name, phoneNumber, domain FROM user WHERE id_user = :idTag;';
            $results = self::SingleDataGetter($id, $sql);
            return $results['0'];
        }

        private static function UpdateUserInfo($id, $sql, $values): void
        {
            try {
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("Failure updating $id");
                }
            } catch (InvalidArgumentException $e) {
                FlashMessages::add("warning", "Error updating");
                header("Location: /Orissa/Home");
            } finally {
                $pdoStatement = null;
            }
        }

        public static function UpdateSurname(int $id, string $surname) : void
        {
            $sql = 'UPDATE user SET surname = :surnameTag WHERE id_user = :idTag';
            $values = [':surnameTag' => $surname, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }

        public static function UpdateFamilyName(int $id, string $familyName) : void
        {
            $sql = 'UPDATE user SET name = :nameTag WHERE id_user = :idTag';
            $values = [':nameTag' => $familyName, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }

        public static function UpdatePhoneNumber(int $id, string $phoneNumber) : void
        {
            $sql = 'UPDATE user SET phoneNumber = :phoneTag WHERE id_user = :idTag';
            $values = [':phoneTag' => $phoneNumber, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }
    }