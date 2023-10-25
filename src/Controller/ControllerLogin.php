<?php

    namespace App\Code\Controller;

    class ControllerLogin extends ControllerGeneric
    {
        /**Login Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Login' => 'view',
            'Login/logging' => 'logging',
        ];

        /**Login Controller's definition of Login body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Login';

        protected function logging() : void
        {
            (new ControllerLogin())->displayView("Logging", "/login.php");
        }
    }