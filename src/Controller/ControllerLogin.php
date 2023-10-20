<?php

    namespace App\Code\Controller;

    class ControllerLogin extends ControllerGeneric
    {
        /**Login Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Login' => 'view',
            'logging' => 'logging',
        ];

        /**Login Controller's definition of Login body's folder directory
         * @return string
         */
        protected function getBodyFolder(): string
        {
            return '/Login';
        }

        protected function logging() : void
        {
            (new ControllerLogin())->displayView("Login", "/login.php");
        }
    }