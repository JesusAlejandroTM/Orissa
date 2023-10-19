<?php

    namespace App\Code\Controller;

    use App\Code\Config\Conf;
    use App\Code\Config\ExceptionHandler;
    use Exception;
    use JetBrains\PhpStorm\NoReturn;

    class ControllerGeneric
    {
        protected function getBodyFolder(): string
        {
            return '/generic';
        }

        public function GetURLIdentifier(): string
        {
            return "id";
        }

        public function afficheVue(string $pagetitle, string $cheminVueBody, array $parametres = []): void
        {

            $parametres += ['pagetitle' => $pagetitle, 'cheminVueBody' => $this->getBodyFolder() . $cheminVueBody];
            extract($parametres); // Crée des variables à partir du tableau $parametres
            require(__DIR__ . '/../View/view.php'); // Charge la vue
        }

        public function error(Exception $e): void
        {
            $errorCode = $e->getCode();
            $errorMessage = ExceptionHandler::getErrorMessage($errorCode);
            $this->afficheVue("Erreur", "/../error.php",
                ["errorMessage" => $errorMessage]);
        }

        #[NoReturn] public function headToFile(string $fileName): void
        {
            header('Location: ' . Conf::getBaseUrl() . '/src/view' . $this->getBodyFolder() . '/' . $fileName);
            exit();
        }
    }