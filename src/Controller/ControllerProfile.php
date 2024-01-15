<?php

    namespace App\Code\Controller;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use App\Code\Model\Repository\UserRepository;

    class ControllerProfile extends AbstractController
    {
        protected static array $routesMap = [
            'Profile' => 'view',
            'Profile/Disconnect' => 'disconnectUser',
        ];

        protected static string $bodyFolder = '/Profile';

        private function checkSession() : void
        {
            $username = UserSession::getLoggedUser();
            if ($username == null) {
                FlashMessages::add("warning", "You must be logged in to access this page");
                header("Location: /Orissa/Home");
                exit();
            }
        }

        public function view(): void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpFile = '/' . strtolower($title) . '.php';
            $this->checkSession();
            $username = UserSession::getLoggedUser();
            $userObject = (new UserRepository())->SelectWithLogin($username);
            var_dump($userObject);
            var_dump($_SESSION);
            $this->displayView($title, $phpFile, [], [$userObject]);
        }

        public function disconnectUser() : void
        {
            $this->checkSession();
            UserSession::disconnect();
            FlashMessages::add("info", "User successfully disconnected");
            header("Location: /Orissa/Home");
        }
    }