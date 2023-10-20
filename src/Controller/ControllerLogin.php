<?php

    namespace App\Code\Controller;

    class ControllerLogin extends ControllerGeneric
    {
        protected function getBodyFolder(): string
        {
            return '/Login';
        }

        public function GetURLIdentifier(): string
        {
            return "username";
        }

        public function getRequestedAction(string $route) : string {
            $routes = [
                'Login' => 'view',
                'logging' => 'logging',
            ];
            return $routes[$route] ?? 'view';
        }

        public function executeAction(string $route): void
        {
            $action = $this->getRequestedAction($route);
            switch ($action){
                case 'view':
                    $this->view();
                    break;
                case 'logging':
                    $this->logging();
                    break;
                default:
                    $this->view();
                    break;
            }
        }

        public static function view() : void
        {
            (new ControllerLogin())->afficheVue("Login", "/login.php");
        }

        public static function logging() : void
        {
            (new ControllerLogin())->afficheVue("Login", "/login.php");
        }
    }