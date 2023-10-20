<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use Exception;

    class ControllerGeneric
    {
        /**Routes map for associated controller, every controller should have
         * this variable redefined accordingly.
         * @var array|string[]
         */
        protected static array $routesMap = ['/Home' => 'view'];

        /**Returns the folder directory with mostly HTML body files
         * associated with the corresponding Controller.
         * @return string
         */
        protected function getBodyFolder(): string
        {
            return '/generic';
        }

        /**Returns routes map associated with the corresponding Controller.
         * @return array|string[]
         */
        protected function getRoutesMap(): array {
            return static::$routesMap;
        }

        /**Get action based on $route if it's found on the routes map.
         * If $route isn't found in routes map, the default action
         * 'view' will be returned instead
         * @param string $route
         * @return string
         */
        public function getRequestedAction(string $route) : string {
            $routesMap = $this->getRoutesMap();

            return $routesMap[$route] ?? 'view';
        }

        /**Execute controller action found with getRequestedAction with route
         * (which returns default action 'view' if route is not found).
         * @param string $route
         * @return void
         */
        public function executeAction(string $route): void
        {
            $action = $this->getRequestedAction($route);
            $this->$action();
        }

        /**Display specific page passed in $pathViewBody into the
         * web interface, this method uses main file view.php to structurize HTMLs
         * @param string $pageTitle
         * @param string $pathViewBody
         * @param array $parameters Optional
         * @return void
         */
        public function displayView(string $pageTitle, string $pathViewBody, array $parameters = []): void
        {
            // On ajoute $pagetitle et $cheminVueBody dans le tableau paramètres
            $parameters += ['pageTitle' => $pageTitle, 'pathViewBody' => $this->getBodyFolder() . $pathViewBody];
            extract($parameters); // Crée des variables à partir du tableau $parametres
            require(__DIR__ . '/../View/view.php'); // Charge la vue
        }


        /**Main view method for each controller using displayView,
         * every controller can use it as long as they have a getBodyFolder method.
         * Which is used to obtain the pageTitle and pathViewBody
         * @return void
         */
        public function view() : void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpfile = '/' . strtolower($title) . '.php';
            $this->displayView($title, $phpfile);
        }

        /**Displays error page based on Exception's error code with specific message.
         * Use error() to handle exceptions along with the
         * ExceptionHandler class methods to efficiently catch exceptions
         * @param Exception $e
         * @return void
         */
        public function error(Exception $e): void
        {
            $errorCode = $e->getCode();
            $errorMessage = ExceptionHandler::getErrorMessage($errorCode);
            $this->displayView("Erreur", "/../error.php",
                ["errorMessage" => $errorMessage]);
        }
    }