<?php

    namespace App\Code\Lib;

    class PasswordManager
    {
        /**
         * The pepper string used to hash passwords
         * @var string $pepperString
         */
        private static string $pepperString = 'WoCb47xsXjUJAF0XXBEspR';

        /**
         * Hashes a password
         * @param string $clearPassword the password to hash
         * @return string the hashed password
         */
        public static function hash(string $clearPassword) : string
        {
            $pepperPassword = hash_hmac('sha256', $clearPassword, self::$pepperString);
            return password_hash($pepperPassword, PASSWORD_DEFAULT);
        }

        /**
         * Verifies a password against a hashed password
         * @param string $clearPassword the password to verify
         * @param string $hashedPassword the hashed password to verify against
         * @return bool true if the password is verified, false otherwise
         */
        public static function verify(string $clearPassword, string $hashedPassword) : bool
        {
            $pepperPassword = hash_hmac('sha256', $clearPassword, self::$pepperString);
            return password_verify($pepperPassword, $hashedPassword);
        }
    }