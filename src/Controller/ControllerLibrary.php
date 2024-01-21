<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use App\Code\Model\DataObject\Library;
    use App\Code\Model\Repository\AbstractRepository;
    use App\Code\Model\Repository\DatabaseConnection;
    use App\Code\Model\Repository\LibraryRepository;
    use App\Code\Model\Repository\LibraryTaxaManager;
    use Exception;

    class ControllerLibrary extends AbstractController
    {
        /**Library Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Library' => 'view',
            'Library/:param:' => 'viewLibrary',
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

        protected function viewLibrary(int $idLibrary): void
        {
            try {
                $this->CheckUserAccess();
                // Get the libray from the URL
                $library = (new LibraryRepository())->Select($idLibrary);

                // Check that the user is owner of the library
                $userId = UserSession::getLoggedId();
                $libraryCreatorId =  $library->getIdUser();
                ExceptionHandler::checkIsTrue($userId == $libraryCreatorId, 608);

                $this->displayView($library->getTitle(), "/selectLibrary.php",
                    ["nan.css"], ["library" => $library]);
            } catch (Exception $e) {
                $errorMessage = ExceptionHandler::getErrorMessage($e->getCode());
                FlashMessages::add("danger", $errorMessage);
                header("Location: /Orissa/Taxa");
                exit();
            }
        }

        protected function displayCreateLibrary(): void
        {
            $this->CheckUserAccess();
            $this->displayView("Create Library", "/createLibrary.php",
                ['library/createStyle.css', 'loaderCreateLibrary.css'], [],
                ['cartScript.js', 'apiDataProcesses.js']);
        }

        protected function createLibrary() : void
        {
            try {
                // Get the data
                $this->CheckUserAccess();
                $userId = UserSession::getLoggedId();
                $_POST['id_creator'] = $userId;

                // Check unique title
                $newLibrary = LibraryRepository::BuildWithForm($_POST);
                $libraryList = LibraryRepository::getUserLibraries($userId);

                if ($libraryList) {
                    foreach ($libraryList as $library) {
                        $temp = $library->getTitle() == $newLibrary->getTitle();
                        ExceptionHandler::checkIsTrue(!$temp, 606);
                    }
                }

                // Insert data
                $idLib = (new LibraryRepository())->insertGetLastId($newLibrary);
                ExceptionHandler::checkIsTrue(is_int($idLib), 605);

                // Insert selected taxas to the library
                if (isset($_POST['listTaxa']))
                {
                    $taxaList = $_POST['listTaxa'];
                    foreach ($taxaList as $taxaId) {
                        $result = LibraryTaxaManager::addTaxaToLib($idLib, $userId, $taxaId);
                        ExceptionHandler::checkIsTrue($result, 607);
                    }
                }


                // Notification and redirect
                $title = $_POST['title'];
                FlashMessages::add("success", "Votre naturothèque " . $title . " a été créé!");
                header("Location: /Orissa/Library");
                exit();
            } catch (Exception $e) {
                $errorMessage = ExceptionHandler::getErrorMessage($e->getCode());
                FlashMessages::add("danger", $errorMessage);
                header("Location: /Orissa/Library");
                exit();
            }
        }
    }