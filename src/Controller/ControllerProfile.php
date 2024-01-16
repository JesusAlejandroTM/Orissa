<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\PasswordManager;
    use App\Code\Lib\UserSession;
    use App\Code\Model\DataObject\User;
    use App\Code\Model\Repository\UserRepository;
    use Exception;
    use http\Header;

    class ControllerProfile extends AbstractController
    {
        protected static array $routesMap = [
            'Profile' => 'view',
            'Profile/Disconnect' => 'disconnectUser',
            'Profile/Settings' => 'viewSettings',
            'Profile/UpdateInfo' => 'updateUser',
            'Profile/Password' => 'viewPasswordSettings',
            'Profile/UpdatePassword' => 'updatePassword',
        ];

        protected static string $bodyFolder = '/Profile';

        private function LoadUserData() : void
        {
            // Check user is logged in before loading data
            if (!$this->CheckUserAccess()) {
                exit();
            }
            $username = UserSession::getLoggedUser();
            global $userObject;
            $userObject = (new UserRepository())->SelectWithLogin($username);
        }

        public function view(): void
        {
            $this->LoadUserData();
            parent::view();
        }

        public function disconnectUser() : void
        {
            $this->LoadUserData();
            UserSession::disconnect();
            FlashMessages::add("info", "User successfully disconnected");
            header("Location: /Orissa/Home");
        }

        public function viewSettings() : void
        {
            $this->LoadUserData();
            $this->displayView("Profile Settings", "/profileSettings.php", []);
        }

        public function updateUser() : void
        {
            try {

                $this->LoadUserData();

                // Get data
                $userId = $_GET['user_id'];
                $user = (new UserRepository())->Select($userId);
                $username = $_GET['username'];
                $email = $_GET['email'];
                $birthdate = $_GET['birthdate'];
                $surname = $_GET['surname'];
                $familyName = $_GET['familyName'];
                $phoneNumber = $_GET['phoneNumber'];
                $inputPassword = $_GET['password'];

                // Check password
                ExceptionHandler::checkIsTrue($user instanceof User, 103);
                $checkPassword = PasswordManager::verify($inputPassword, $user->getHashedPassword());
                ExceptionHandler::checkIsTrue($checkPassword, 103);

                // Update data
                if (!is_null($username) && $username != '') $user->setUsername($username);
                if (!is_null($email) && $email != '') $user->setMail($email);
                if (!is_null($birthdate) && $birthdate != '') $user->setBirthDate($birthdate);
                (new UserRepository())->Update($user);

                if (!is_null($surname) && $surname != '') UserRepository::UpdateSurname($userId, $surname);
                if (!is_null($familyName) && $familyName != '') UserRepository::UpdateFamilyName($userId, $familyName);
                if (!is_null($phoneNumber) && $phoneNumber != '') UserRepository::UpdatePhoneNumber($userId, $phoneNumber);

                // Redirect
                UserSession::connect($user->getUsername());
                FlashMessages::add('success', 'Update was successful');
                header("Location: /Orissa/Profile");
            } catch (Exception $e) {
                FlashMessages::add("danger", "Verifiez votre mot de passe");
                // Redirect user if login failed
                header("Location: /Orissa/Profile/Settings");
                exit();
            }
        }

        public function viewPasswordSettings(): void
        {
            $this->LoadUserData();
            $this->displayView("Profile Settings", "/passwordSettings.php", []);
        }

        public function updatePassword() : void
        {
            try {
                // Get the data
                $user = (new UserRepository())->Select($_GET['user_id']);
                $inputPassword = $_GET['oldPassword'];
                $inputNewPassword = $_GET['newPassword'];
                $inputCheckNewPassword = $_GET['newPasswordCheck'];
                ExceptionHandler::checkIsTrue($inputPassword != $inputNewPassword, 103);

                // Check current password
                ExceptionHandler::checkIsTrue($user instanceof User, 103);
                $checkPassword = PasswordManager::verify($inputPassword, $user->getHashedPassword());
                ExceptionHandler::checkIsTrue($checkPassword, 103);

                // Check new password
                ExceptionHandler::checkIsEqual($inputNewPassword, $inputCheckNewPassword, 103);

                // Hash and update database
                $user->setHashedPassword($inputNewPassword);
                (new UserRepository())->Update($user);

                // Redirect
                header("Location: /Orissa/Profile");
                exit();
            } catch (Exception $e) {
                FlashMessages::add("danger", "Vérifiez que vos mot de passes sont corrects");
                // Redirect user if login failed
                header("Location: /Orissa/Profile/Password");
                exit();
            }
        }
    }