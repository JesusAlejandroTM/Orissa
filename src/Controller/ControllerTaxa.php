<?php

    namespace App\Code\Controller;

    class ControllerTaxa extends AbstractController
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Taxa' => 'view',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Taxa';
    }