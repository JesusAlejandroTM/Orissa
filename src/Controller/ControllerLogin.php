<?php

    namespace App\Code\Controller;

    class ControllerLogin extends ControllerGeneric
    {
        protected function getBodyFolder(): string
        {
            return '/Login';
        }

        protected function getControllerRoutes(): array {
            return [
                'Login' => 'view',
                'logging' => 'logging',
            ];
        }

        public function executeAction(string $route): void
        {
            $action = $this->getRequestedAction($route);
            switch ($action){
                case 'logging':
                    $this->logging();
                    break;
                default:
                    $this->view();
                    break;
            }
        }

        private function logging() : void
        {
            (new ControllerLogin())->afficheVue("Login", "/login.php");
        }
    }