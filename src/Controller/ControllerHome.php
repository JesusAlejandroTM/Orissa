<?php

    namespace App\Code\Controller;

    class ControllerHome extends ControllerGeneric
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Home' => 'view',
            'test' => 'test',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected function getBodyFolder(): string
        {
            return '/Home';
        }
    }