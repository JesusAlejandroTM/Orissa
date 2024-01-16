<?php

    namespace App\Code\Controller;

    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use App\Code\Model\DataObject\User;
    use App\Code\Model\Repository\UserRepository;
    use http\Header;

    class ControllerProfile extends AbstractController
    {
        protected static array $routesMap = [
            'Profile' => 'view',
            'Profile/Disconnect' => 'disconnectUser',
            'Profile/Settings' => 'viewSettings',
            'Profile/Update' => 'updateUser',
        ];

        protected static string $bodyFolder = '/Profile';

        private function checkProfileAccess() : void
        {
            $username = UserSession::getLoggedUser();
            if ($username == null) {
                FlashMessages::add("warning", "You must be logged in to access this page");
                header("Location: /Orissa/Home");
                exit();
            }
            $username = UserSession::getLoggedUser();
            global $userObject;
            $userObject = (new UserRepository())->SelectWithLogin($username);
        }

        public function view(): void
        {
            $this->checkProfileAccess();
            parent::view();
        }

        public function disconnectUser() : void
        {
            $this->checkProfileAccess();
            UserSession::disconnect();
            FlashMessages::add("info", "User successfully disconnected");
            header("Location: /Orissa/Home");
        }

        public function viewSettings() : void
        {
            $this->checkProfileAccess();
            $this->displayView("Profile Settings", "/profileSettings.php", []);
        }

        public function updateUser() : void
        {

            $this->checkProfileAccess();
            /** @var User $user */

            $userId = $_GET['user_id'];
            $user = (new UserRepository())->Select($userId);

            $username = $_GET['username'];
            $email = $_GET['email'];
            $birthdate = $_GET['birthdate'];
            $surname = $_GET['surname'];
            $familyName = $_GET['familyName'];
            $phoneNumber = $_GET['phoneNumber'];

            if (!is_null($username) && $username != '') $user->setUsername($username);
            if (!is_null($email) && $email != '') $user->setMail($email);
            if (!is_null($birthdate) && $birthdate != '') $user->setBirthDate($birthdate);
            (new UserRepository())->Update($user);

            if (!is_null($surname) && $surname != '') UserRepository::UpdateSurname($userId, $surname);
            if (!is_null($familyName) && $familyName != '') UserRepository::UpdateFamilyName($userId, $familyName);
            if (!is_null($phoneNumber) && $phoneNumber != '') UserRepository::UpdatePhoneNumber($userId, $phoneNumber);
            UserSession::connect($user->getUsername());


            FlashMessages::add('success', 'Update was successful');
            header("Location: /Orissa/Profile");
        }
    }