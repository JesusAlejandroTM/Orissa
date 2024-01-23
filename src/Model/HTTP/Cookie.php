<?php

    namespace App\Code\Model\HTTP;

    class Cookie
    {
        /**
         * Save a cookie in the browser with a key, a value and an optional expiration time
         * @param string $key the key of the cookie
         * @param mixed $value the value of the cookie
         * @param int|null $expireTime the expiration time of the cookie
         * @return void
         */
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

        /**
         * Read a cookie from the browser
         * @param string $key the key of the cookie
         * @return mixed the value of the cookie
         */
        public static function read(string $key) : mixed
        {
            return unserialize($_COOKIE[$key]) ?? null;
        }

        /**
         * Check if a cookie exists in the browser with a key
         * @param string $key the key of the cookie
         * @return bool true if the cookie exists, false otherwise
         */
        public static function contains(string $key) : bool
        {
            if (isset($_COOKIE[$key])){
                return true;
            }
            else return false;
        }

        /**
         * Delete a cookie from the browser with a key
         * @param $key mixed key of the cookie
         * @return void
         */
        public static function delete($key) : void
        {
            if (isset($_COOKIE[$key])){
                unset($_COOKIE[$key]);
            }
        }
    }