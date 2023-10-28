<?php

    namespace App\Code\Lib;

    class PasswordManager
    {
        private static string $pepperString = 'WoCb47xsXjUJAF0XXBEspR';

        public static function hash(string $clearPassword) : string
        {
            $pepperPassword = hash_hmac('sha256', $clearPassword, self::$pepperString);
            return password_hash($pepperPassword, PASSWORD_DEFAULT);
        }

        public static function verify(string $clearPassword, string $hashedPassword) : bool
        {
            $pepperPassword = hash_hmac('sha256', $clearPassword, self::$pepperString);
            return password_verify($pepperPassword, $hashedPassword);
        }
    }