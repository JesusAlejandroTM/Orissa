<?php

    namespace App\Code\Lib;
    use App\Code\Model\HTTP\Session;
    use App\Code\Model\Repository\UserRepository;

    class UserSession
    {
        private static string $_loginKey = '_connectedUser';
        private static string $_idKey = '_connectedUserId';

        /**
         * Connects a user to the session
         * @param string $loginUtilisateur
         * @return void
         */
        public static function connect(string $loginUtilisateur): void
        {
            $session = Session::getInstance();
            $user = (new UserRepository())->SelectWithLogin($loginUtilisateur);
            $session->save(self::$_loginKey, $loginUtilisateur);
            $session->save(self::$_idKey, $user->getId());
        }

        /**
         * Checks if a user is connected
         * @return bool true if connected, false otherwise
         */
        public static function isConnected(): bool
        {
            $session = Session::getInstance();
            return $session->contains(self::$_loginKey);
        }

        /**
         * Disconnects a user from the session
         * @return void
         */
        public static function disconnect(): void
        {
            $session = Session::getInstance();
            $session->delete(self::$_loginKey);
            $session->delete(self::$_idKey);
        }

        /**
         * Gets the login of the connected user
         * @return string|null the login of the connected user, null otherwise
         */
        public static function getLoggedUser(): ?string
        {
            $session = Session::getInstance();
            if (self::isConnected()) {
                return $session->read(static::$_loginKey);
            } else return null;
        }

        /**
         * Gets the id of the connected user
         * @return string|null the id of the connected user, null otherwise
         */
        public static function getLoggedId(): ?string
        {
            $session = Session::getInstance();
            if (self::isConnected()) {
                return $session->read(static::$_idKey);
            } else return null;
        }

//        public static function estAdministrateur(): bool
//        {
//            if (UserSession::estConnecte()) {
//                $login = UserSession::getLoginUtilisateurConnecte();
//                $user = UserRepository::selectWithUsername($login, true);
//                if ($user-> --IS ADMIN-- ()) {
//                    return true;
//                } else {
//                    return false;
//                }
//            } else return false;
//        }
    }