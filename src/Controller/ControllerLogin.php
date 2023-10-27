<?php

    namespace App\Code\Controller;

    use Cassandra\Date;
    use DateTime;

    class ControllerLogin extends ControllerGeneric
    {
        /**Login Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Login' => 'view',
            'Login/logging' => 'logging',
            'Login/CreateAccount' => 'displayCreateAccount',
            'Login/create' => 'creatingAccount',
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

            (new ControllerLogin())->displayView("Logging", "/Login.php", ['style.css']);
        }

        protected function displayCreateAccount() : void
        {
            (new ControllerLogin())->displayView("Create an account", "/CreateAccount.php", ['style.css']);
        }

        protected function creatingAccount() : void
        {
            $birthdateString = $_GET['birthdate'];
            var_dump($birthdateString);
            $birthdate = new Date($birthdateString);
            var_dump($birthdate);
            (new ControllerLogin())->displayView("Account created", "/CreateAccount.php", ['style.css']);
        }
    }