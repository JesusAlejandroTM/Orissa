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
    }