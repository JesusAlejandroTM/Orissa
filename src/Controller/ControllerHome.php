<?php

    namespace App\Code\Controller;

    class ControllerHome extends ControllerGeneric
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Home' => 'view',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Home';
    }