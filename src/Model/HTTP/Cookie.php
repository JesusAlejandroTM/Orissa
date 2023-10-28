<?php

    namespace App\Code\Model\HTTP;

    class Cookie
    {
        public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void
        {
            $valeur = serialize($valeur);
            if (is_null($dureeExpiration)){
                setcookie($cle, $valeur, null);
            }
            else {
                setcookie($cle, $valeur, time() + $dureeExpiration);
            }
        }
        public static function read(string $cle) : mixed
        {
            return unserialize($_COOKIE[$cle]) ?? null;
        }
        public static function contains(string $cle) : bool
        {
            if (isset($_COOKIE[$cle])){
                return true;
            }
            else return false;
        }
        public static function delete($cle) : void
        {
            if (isset($_COOKIE[$cle])){
                unset($_COOKIE[$cle]);
            }
        }
    }