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
            //TODO TRY LOGGING INTO EXISTING ACCOUNT, REMINDER PASSWORD IS lol
            try {
                $user = (new UserRepository())->selectWithUsername($_GET['username']);
                $inputPassword = $_GET['password'];

                ExceptionHandler::checkTrueValue($user instanceof User, 103);
                $checkPassword = PasswordManager::verify($inputPassword, $user->getHashedPassword());
                ExceptionHandler::checkTrueValue($checkPassword, 103);

                FlashMessages::add("success", "Bonjour " . $user->getUsername() . "!");
                UserSession::connect($user->getUsername());
                (new ControllerLogin())->view();
            } catch (Exception $e) {
                FlashMessages::add("danger", "Vérifiez que vos informations sont corrects!");
                (new ControllerLogin())->error($e);
            }
        }

//        public static function logging(): void
//        {
////            try {
////                $user = (new UtilisateurRepository())->select($_GET['login']);
////                $mdpClair = $_GET['mdpClair'];
////                ExceptionHandling::checkTrueValue($user instanceof Utilisateur, 113);
////                ExceptionHandling::checkTrueValue(MotDePasse::verifier($mdpClair, $user->getMdpHache()), 114);
////                ConnexionUtilisateur::connecter($user->getPrimaryKeyValue());
////                MessageFlash::ajouter("success", "Bienvenue, " . $user->getPrimaryKeyValue() . '!');
////                self::readAll();
////            } catch (Exception $e) {
////                if ($e->getCode() === 113) {
////                    MessageFlash::ajouter("warning", "Cet utilisateur n'existe pas");
////                    self::connexion();
////                } else if ($e->getCode() === 114) {
////                    MessageFlash::ajouter("warning", "Vérifiez votre mot de passe");
////                    self::connexion();
////                } else {
////                    MessageFlash::ajouter("danger", "Erreur durant la connexion, veuillez réessayer");
////                    (new ControllerUtilisateur())->error($e);
////                }
////            }
//        }

        protected function displayCreateAccount() : void
        {
            (new ControllerLogin())->displayView("Create an account", "/CreateAccount.php", ['style.css']);
        }

        protected function creatingAccount() : void
        {
            $birthDate = new DateTime($_GET['birthdate']);
            $_GET['birthdate'] = date_format($birthDate, 'Y-m-d');
            $createdUser = UserRepository::construireAvecFormulaire($_GET);
            UserRepository::sauvegarder($createdUser);
            (new ControllerLogin())->displayView("Account created", "/CreateAccount.php", ['style.css']);
        }
    }