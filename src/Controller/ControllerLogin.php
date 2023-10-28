<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\PasswordManager;
    use App\Code\Lib\UserSession;
    use App\Code\Model\DataObject\User;
    use App\Code\Model\Repository\UserRepository;
    use DateTime;
    use Exception;

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
            try {
                $user = (new UserRepository())->selectWithUsername($_GET['username']);
                $inputPassword = $_GET['password'];

                ExceptionHandler::checkTrueValue($user instanceof User, 103);
                $checkPassword = PasswordManager::verify($inputPassword, $user->getHashedPassword());
                ExceptionHandler::checkTrueValue($checkPassword, 103);

                FlashMessages::add("success", "Bonjour " . $user->getUsername() . "!");
                UserSession::connect($user->getUsername());
                header("Location: /Orissa/Home");
                exit();
            } catch (Exception $e) {
                FlashMessages::add("danger", "Vérifiez que vos informations sont corrects!");
                (new ControllerLogin())->view();
            }
        }

        protected function displayCreateAccount() : void
        {
            (new ControllerLogin())->displayView("Create an account", "/CreateAccount.php", ['style.css']);
        }

        protected function creatingAccount() : void
        {
            try {
                $birthDate = new DateTime($_GET['birthdate']);
                $_GET['birthdate'] = date_format($birthDate, 'Y-m-d');
                $createdUser = UserRepository::construireAvecFormulaire($_GET);
                $result = UserRepository::sauvegarder($createdUser);
                ExceptionHandler::checkTrueValue($result, 104);

                FlashMessages::add("success", "Bienvue à Orissa, " . $createdUser->getUsername() . "!");
                UserSession::connect($createdUser->getUsername());
                header("Location: /Orissa/Home");
                exit();
            } catch (Exception $e){
                if ($e->getCode() == 104){
                    FlashMessages::add("danger", "Cet utilisateur existe déjà");
                    (new ControllerLogin())->error($e);
                }
            }
        }
    }