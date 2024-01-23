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


        /**
         * Build a User object from an array of data
         * @param array $arrayData the array of data
         * @return User|bool the User object built or false if an error occurred
         */
        protected function Build(array $arrayData): User|bool
        {
            if (empty($arrayData)) return false;
            else return new User(...array_values($arrayData));
        }

        protected function GetColumnsNames(): array
        {
            return ["id_user", "mail", "username", "hashedPassword", "birthDate", "role"];
        }

        /**
         * Build a User object from a form input array (the password is hashed)
         * @param array $userArray the input array from a form
         * @return User the User object built
         */
        public static function BuildWithForm(array $userArray) : User
        {
            $email = $userArray['email'];
            $username = $userArray['username'];
            $password = PasswordManager::hash($userArray['password']);
            $birthdate = $userArray['birthdate'];
            return new User(null, $email, $username, $password, $birthdate, "User");
        }

        /**
         * Get a user object from its login username
         * @param string $login the login username
         * @return User|string the User object built or an error message if an error occurred
         */
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

        /**
         * Get the extra information from a user from its id (creation date, surname, name and phoneNumber)
         * @param int $id
         * @return array|null
         */
        public static function GetUserExtraInfo(int $id) : ?array
        {
            $sql = 'SELECT created_at, surname, name, phoneNumber, domain FROM user WHERE id_user = :idTag;';
            $results = self::SingleDataGetter($id, $sql);
            return $results['0'];
        }

        /**
         * Update the extra informatiom from an user with its id and the passed values
         * @param $id int the id of the user
         * @param $sql string the SQL query to execute
         * @param $values array the values to pass to the SQL query
         * @return void
         */
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

        /**
         * Update the surname of a user from its id and the passed surname
         * @param int $id the id of the user
         * @param string $surname the new surname
         * @return void
         */
        public static function UpdateSurname(int $id, string $surname) : void
        {
            $sql = 'UPDATE user SET surname = :surnameTag WHERE id_user = :idTag';
            $values = [':surnameTag' => $surname, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }

        /**
         * Update the family name of a user from its id and the passed family name
         * @param int $id the id of the user
         * @param string $familyName the new family name
         * @return void
         */
        public static function UpdateFamilyName(int $id, string $familyName) : void
        {
            $sql = 'UPDATE user SET name = :nameTag WHERE id_user = :idTag';
            $values = [':nameTag' => $familyName, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }

        /**
         * Update the phone number of a user from its id and the passed phone number
         * @param int $id the id of the user
         * @param string $phoneNumber the new phone number
         * @return void
         */
        public static function UpdatePhoneNumber(int $id, string $phoneNumber) : void
        {
            $sql = 'UPDATE user SET phoneNumber = :phoneTag WHERE id_user = :idTag';
            $values = [':phoneTag' => $phoneNumber, ':idTag' => $id];
            self::UpdateUserInfo($id, $sql, $values);
        }
    }