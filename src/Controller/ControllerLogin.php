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
            'Login/CreateAccount' => 'displayCreateAccount',
            'Login/Create' => 'creatingAccont',
        ];

        /**Login Controller's definition of Login body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Login';

        public function view() : void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpfile = '/' . strtolower($title) . '.php';
            //FIXME MAKE A CSS FILE BY DEFAULT FOR VIEWS?
            $this->displayView($title, $phpfile,  ['style.css']);
        }

        protected function logging() : void
        {

            (new ControllerLogin())->displayView("Logging", "/login.php", ['style.css']);
        }

        protected function displayCreateAccount() : void
        {
            (new ControllerLogin())->displayView("Create an account", "/CreateAccount.php", ['style.css']);
        }

        protected function creatingAccount() : void
        {
            (new ControllerLogin())->displayView("Account created", "/CreateAcount.php", ['style.css']);
        }
    }