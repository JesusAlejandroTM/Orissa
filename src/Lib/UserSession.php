<?php

    namespace App\Code\Lib;
    use App\Code\Model\HTTP\Session;

    class UserSession
    {
        private static string $cleConnexion = '_connectedUser';

        public static function connect(string $loginUtilisateur): void
        {
            $session = Session::getInstance();
            $session->save(self::$cleConnexion, $loginUtilisateur);
        }

        public static function isConnected(): bool
        {
            $session = Session::getInstance();
            return $session->contains(self::$cleConnexion);
        }

        public static function disconnect(): void
        {
            $session = Session::getInstance();
            $session->delete(self::$cleConnexion);
        }

        public static function getLoginUtilisateurConnecte(): ?string
        {
            $session = Session::getInstance();
            if (self::isConnected()) {
                return $session->read(static::$cleConnexion);
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