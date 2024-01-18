<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use App\Code\Model\Repository\LibraryRepository;
    use Exception;

    class ControllerLibrary extends AbstractController
    {
        /**Library Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Library' => 'view',
            'Library/CreateLibrary' => 'displayCreateLibrary',
            'Library/LibraryCreation' => 'createLibrary',
        ];

        /**Library Controller's definition of Library body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Library';

        public function view(): void
        {
            if (UserSession::isConnected()) $this->displayView("Library", "/library.php",  []);
            else $this->displayView("Library", "/loginError.html",  []);
        }

        protected function displayCreateLibrary(): void
        {
            $this->CheckUserAccess();
            $this->displayView("Create Library", "/createLibrary.php",
                ['library/createStyle.css'], [], ['cartScript.js']);
        }

        protected function createLibrary() : void
        {
            try {
                // Get the data
                $this->CheckUserAccess();
                $userId = UserSession::getLoggedId();
                $_GET["id_creator"] = $userId;

                // Check unique title
//                $newLibrary = LibraryRepository::BuildWithForm($_GET);
//                $libraryList = LibraryRepository::getUserLibraries($userId);
//
//                if ($libraryList) {
//                    foreach ($libraryList as $library) {
//                        $temp = $library->getTitle() == $newLibrary->getTitle();
//                        ExceptionHandler::checkIsTrue(!$temp, 606);
//                    }
//                }
//
//                // Insert data
//                $result = (new LibraryRepository())->Insert($newLibrary);
//                ExceptionHandler::checkIsTrue(!is_string($result), 605);
//
//                // Notification and redirect
//                $title = $_GET['title'];
//                FlashMessages::add("success", "Votre naturothèque " . $title . " a été créé!");
                var_dump($GLOBALS);
                var_dump($_SERVER);
//                header("Location: /Orissa/Library");
//                exit();
            } catch (Exception $e) {
                $errorMessage = ExceptionHandler::getErrorMessage($e->getCode());
                FlashMessages::add("danger", $errorMessage);
                header("Location: /Orissa/Library/CreateLibrary");
                exit();
            }
        }
    }