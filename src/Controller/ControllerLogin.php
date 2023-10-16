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

        public static function logging() : void
        {
            var_dump($_GET);

        }
    }