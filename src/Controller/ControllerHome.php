<?php

    namespace App\Code\Controller;

    class ControllerHome extends ControllerGeneric
    {
        protected function getBodyFolder(): string
        {
            return '/Home';
        }

        protected function getControllerRoutes(): array {
            return [
                'Home' => 'view',
            ];
        }

        public function executeAction(string $route): void
        {
            $action = $this->getRequestedAction($route);
            switch ($action){
                default:
                    $this->view();
                    break;
            }
        }
    }