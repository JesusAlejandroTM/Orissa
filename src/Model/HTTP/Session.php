<?php

    namespace App\Code\Model\HTTP;

    use App\Code\Config\Conf;
    use Exception;

    class Session
    {
        public static ?Session $instance = null;

        /**
         * Session constructor, start the session and check the last activity
         * Singleton pattern allows only one instance of the session to be created
         * @throws Exception
         */
        private function __construct()
        {
            session_set_cookie_params(Conf::$sessionDuration);
            if (session_start() === false)
            {
                throw new Exception("La session n'a pas réussi à démarrer");
            }
            $this->checkLastActivity();
        }

        /**
         * Check the last activity of the session and destroy it if it is too old
         * @return void
         */
        public function checkLastActivity(): void
        {
            if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > Conf::$sessionDuration))
            {
                session_unset();
            }
            $_SESSION['lastActivity'] = time();
        }

        /**
         * Check if a session variable exists
         * @param string $name the name of the session variable
         * @return bool true if the session variable exists, false otherwise
         */
        public function contains(string $name): bool
        {
            return isset($_SESSION[$name]);
        }

        /**
         * Save a session variable with a key and a value in the session
         * @param string $cle the key of the session variable
         * @param mixed $valeur the value of the session variable
         * @return void
         */
        public function save(string $cle, mixed $valeur) : void
        {
            $_SESSION[$cle] = $valeur;
        }

        /**
         * Read a session variable from the session with a key and return its value
         * @param string $cle the key of the session variable
         * @return mixed the value of the session variable
         */
        public function read(string $cle) : mixed
        {
            return $_SESSION[$cle];
        }

        /**
         * Delete a session variable from the session with a key if it exists
         * @param string $cle the key of the session variable
         * @return void
         */
        public function delete(string $cle) : void
        {
            if (isset($_SESSION[$cle])) {
                unset($_SESSION[$cle]);
            }
        }

        /**
         * Get the instance of the session and create it if it does not exist
         * @return Session the instance of the session
         */
        public static function getInstance() : Session
        {
            if (is_null(static::$instance))
            {
                static::$instance = new Session();
            }
            return static::$instance;
        }

        /**
         * Destroy the session and delete the cookie associated with it
         * @return void
         */
        public static function destroy() : void
        {
            session_unset();
            session_destroy();
            Cookie::delete(session_name());
            static::$instance = null;
        }
    }