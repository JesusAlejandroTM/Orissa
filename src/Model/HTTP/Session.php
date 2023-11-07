<?php

    namespace App\Code\Model\HTTP;

    use App\Code\Config\Conf;
    use Exception;

    class Session
    {
        public static ?Session $instance = null;

        private function __construct()
        {
            session_set_cookie_params(Conf::$sessionDuration);
            if (session_start() === false)
            {
                throw new Exception("La session n'a pas réussi à démarrer");
            }
            $this->checkLastActivity();
        }

        public function checkLastActivity(): void
        {
            if (isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > Conf::$sessionDuration))
            {
                session_unset();
            }
            $_SESSION['lastActivity'] = time();
        }

        public function contains(string $name): bool
        {
            return isset($_SESSION[$name]);
        }

        public function save(string $cle, mixed $valeur) : void
        {
            $_SESSION[$cle] = $valeur;
        }

        public function read(string $cle) : mixed
        {
            return $_SESSION[$cle];
        }

        public function delete(string $cle) : void
        {
            if (isset($_SESSION[$cle])) {
                unset($_SESSION[$cle]);
            }
        }

        public static function getInstance() : Session
        {
            if (is_null(static::$instance))
            {
                static::$instance = new Session();
            }
            return static::$instance;
        }

        public static function destroy() : void
        {
            session_unset();
            session_destroy();
            Cookie::delete(session_name());
            static::$instance = null;
        }
    }