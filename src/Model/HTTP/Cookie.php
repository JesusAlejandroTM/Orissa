<?php

    namespace App\Code\Model\HTTP;

    class Cookie
    {
        public static function save(string $key, mixed $value, ?int $expireTime = null): void
        {
            $value = serialize($value);
            if (is_null($expireTime)){
                setcookie($key, $value, null);
            }
            else {
                setcookie($key, $value, time() + $expireTime);
            }
        }
        public static function read(string $key) : mixed
        {
            return unserialize($_COOKIE[$key]) ?? null;
        }
        public static function contains(string $key) : bool
        {
            if (isset($_COOKIE[$key])){
                return true;
            }
            else return false;
        }
        public static function delete($key) : void
        {
            if (isset($_COOKIE[$key])){
                unset($_COOKIE[$key]);
            }
        }
    }