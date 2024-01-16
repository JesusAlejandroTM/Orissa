<?php

    namespace App\Code\Lib;
    use App\Code\Model\HTTP\Session;
    use App\Code\Model\Repository\UserRepository;

    class UserSession
    {
        private static string $_loginKey = '_connectedUser';
        private static string $_idKey = '_connectedUserId';

        public static function connect(string $loginUtilisateur): void
        {
            $session = Session::getInstance();
            $user = (new UserRepository())->SelectWithLogin($loginUtilisateur);
            $session->save(self::$_loginKey, $loginUtilisateur);
            $session->save(self::$_idKey, $user->getId());
        }

        public static function isConnected(): bool
        {
            $session = Session::getInstance();
            return $session->contains(self::$_loginKey);
        }

        public static function disconnect(): void
        {
            $session = Session::getInstance();
            $session->delete(self::$_loginKey);
        }

        public static function getLoggedUser(): ?string
        {
            $session = Session::getInstance();
            if (self::isConnected()) {
                return $session->read(static::$_loginKey);
            } else return null;
        }

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