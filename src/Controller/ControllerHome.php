<?php

    namespace App\Code\Controller;

    class ControllerHome extends ControllerGeneric
    {
        protected function getBodyFolder(): string
        {
            return '/Home';
        }

        public function GetURLIdentifier(): string
        {
            return "username";
        }

        public function getRequestedAction(string $route) :string {
            $routes = [
                'Home' => 'view',
            ];

            return $routes[$route];
        }

        public function executeAction(string $route): void
        {
            $action = $this->getRequestedAction($route);
            switch ($action){
                case 'view':
                    $this->view();
                    break;
                default:
                    $this->view();
                    break;
            }
        }

        public static function view() : void
        {
            (new ControllerHome())->afficheVue("Home", "/home.php");
        }
    }