<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use Exception;

    class ControllerGeneric
    {
        // Obtenir le dossier où se trouve les fichiers vues concernant le controlleur correspondant
        protected function getBodyFolder(): string
        {
            return '/generic';
        }

        // Roûtes du contrôleur correspondant
        protected function getControllerRoutes(): array {
            return ['/Home' => 'view'];
        }

        // Obtenir l'action correspondant à la route mis en paramètre, on cherche cette route dans getControllerRoutes()
        // Si elle n'existe pas, nous passons l'action 'view'
        public function getRequestedAction(string $route) : string {
            $routes = $this->getControllerRoutes();

            return $routes[$route] ?? 'view';
        }

        // Afficher la page
        public function afficheVue(string $pagetitle, string $cheminVueBody, array $parametres = []): void
        {
            $parametres += ['pagetitle' => $pagetitle, 'cheminVueBody' => $this->getBodyFolder() . $cheminVueBody];
            extract($parametres); // Crée des variables à partir du tableau $parametres
            require(__DIR__ . '/../View/view.php'); // Charge la vue
        }

        public function view() : void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpfile = '/' . strtolower($title) . '.php';
            $this->afficheVue($title, $phpfile);
        }

        public function error(Exception $e): void
        {
            $errorCode = $e->getCode();
            $errorMessage = ExceptionHandler::getErrorMessage($errorCode);
            $this->afficheVue("Erreur", "/../error.php",
                ["errorMessage" => $errorMessage]);
        }
    }