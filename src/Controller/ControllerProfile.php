<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\PasswordManager;
    use App\Code\Lib\UserSession;
    use App\Code\Model\DataObject\User;
    use App\Code\Model\Repository\LibraryRepository;
    use App\Code\Model\Repository\TaxaRegisters;
    use App\Code\Model\Repository\UserRepository;
    use Exception;
    use http\Header;

    class ControllerProfile extends AbstractController
    {
        protected static array $routesMap = [
            'Profile' => 'view',
            'Profile/Registers' => 'viewRegisteredTaxas',
            'Profile/Disconnect' => 'disconnectUser',
            'Profile/Settings' => 'viewSettings',
            'Profile/Password' => 'viewPasswordSettings',
            'Profile/UpdateInfo' => 'updateUser',
            'Profile/UpdatePassword' => 'updatePassword',
            'Profile/DeleteAccount' => 'deleteUserAccount',
        ];

        /**
         * Profile Controller's definition of profile body's folder directory
         * @var string
         */
        protected static string $bodyFolder = '/Profile';

        /**
         * Loads the user data from the database
         * If the user is not logged in, redirects to the home page
         * @return void
         */
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

        /**
         * Displays the profile page if the user is logged in or redirect if not
         * @return void
         */
        public function view(): void
        {
            $this->LoadUserData();
            $userId = UserSession::getLoggedId();
            $libraries = LibraryRepository::getUserLibraries($userId);
            $this->displayView('Profile', '/profile.php',
                ['profile/profile.css', 'profile/profileMobile.css'], ["libraries" => $libraries]);
        }

        /**
         * Displays the registered taxas page if the user is logged in or redirect if not
         * @return void
         */
        public function viewRegisteredTaxas() : void
        {
            $this->LoadUserData();
            $userId = UserSession::getLoggedId();
            $taxas = TaxaRegisters::SelectRegisteredTaxas($userId);
            $this->displayView('Profile', '/profile.php',
                ['profile/profile.css', 'profile/profileMobile.css'], ["taxas" => $taxas],
                ['registersDisplay.js', 'apiDataProcesses.js']);
        }

        /**
         * Disconnects the user from the session and redirects to the home page with a notification
         * @return void
         */
        public function disconnectUser() : void
        {
            $this->LoadUserData();
            UserSession::disconnect();
            FlashMessages::add("info", "Déconnexion réussie");
            header("Location: /Orissa/Home");
        }

        /**
         * Displays the profile settings page if the user is logged in or redirect if not
         * @return void
         */
        public function viewSettings() : void
        {
            $this->LoadUserData();
            $this->displayView("Profile Settings", "/profileSettings.php",
                ["profile/profileEdit.css"]);
        }

        /**
         * Deletes the user account from the database and disconnects the user from the session
         * @return void
         */
        protected function deleteUserAccount(): void
        {
            try {
                $this->LoadUserData();
                $userId = UserSession::getLoggedId();
                $result = (new UserRepository())->Delete($userId);
                var_dump($result);
                ExceptionHandler::checkIsTrue($result, 105);

                UserSession::disconnect();
                FlashMessages::add('success', 'Suppréssion de compte réussie');
                header("Location: /Orissa/Home");
            } catch (Exception $e) {
                $errorMessage = ExceptionHandler::getErrorMessage($e->getCode());
                FlashMessages::add("danger", $errorMessage);
                // Redirect user if delete account failed
                header("Location: /Orissa/Profile");
                exit();
            }
        }

        /**
         * Updates the user data in the database and redirects to the profile page with a notification
         * Available user information is displayed in the form and the user can choose which information to update
         * @return void
         */
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

        /**
         * Displays the password settings page if the user is logged in or redirect if not
         * @return void
         */
        public function viewPasswordSettings(): void
        {
            $this->LoadUserData();
            $this->displayView("Profile Settings", "/passwordSettings.php",
                ["profile/profileEdit.css"]);
        }

        /**
         * Updates the user password in the database and redirects to the profile page with a notification
         * The inputs are checked to make sure they are valid
         * @return void
         */
        public function updatePassword() : void
        {
            try {
                // Get the data
                $user = (new UserRepository())->Select($_GET['user_id']);
                $inputOldPassword = $_GET['oldPassword'];
                $inputNewPassword = $_GET['newPassword'];
                $inputCheckNewPassword = $_GET['newPasswordCheck'];
                ExceptionHandler::checkIsTrue($inputOldPassword != $inputNewPassword, 103);

                // Check current password
                ExceptionHandler::checkIsTrue($user instanceof User, 103);
                $checkPassword = PasswordManager::verify($inputOldPassword, $user->getHashedPassword());
                ExceptionHandler::checkIsTrue($checkPassword, 103);

                // Check new password
                ExceptionHandler::checkIsEqual($inputNewPassword, $inputCheckNewPassword, 103);

                // Hash and update database
                $user->setHashedPassword($inputNewPassword);
                $result = (new UserRepository())->Update($user);
                ExceptionHandler::checkIsTrue(!is_string($result), 103);
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