<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use Exception;

     /**ControllerGeneric is the parent controller which allows to create child controllers with dynamic
     * and flexible methods. Every child controller must redefine $routesMap and $bodyFolder to function
     * properly. A controller is associated with a folder under the View directory, for example a controller
     * who manages the login system should be called ControllerLogin and have a Login folder under the View
     * directory so classes, actions and files can be found.
     * To extend ControllerGeneric into child controllers, you can redefine $routesMap and $bodyFolder and
     * create the actions like this :
     *
     *      // Extending ControllerGeneric :
     *
     *      class ControllerLogin extends ControllerGeneric {
     *
     *      // Definition of $bodyFolder :
     *
     *          protected static string $bodyFolder = '/Login';
     *
     *      // Definition of $routesMap :
     *
     *          protected static array $routesMap = [
     *          'Login' => 'view',      -> Default action for view
     *          'Logging' => 'logging', -> Reading Logging in the URI will trigger the action logging
     *          ];
     *
     *      // Creation of a logging action :
     *
     *          protected function logging() : void
     *          {
     *          (new ControllerLogin())->displayView("Logging", "/login.php");
     *          }
     *      }
     *
     *      
     */
    class ControllerGeneric
    {
        /**The routes map allows to control actions that are defined in the array
         * and execute methods accordingly. They are associated with a corresponding
         * controller, every controller should have this variable redefined accordingly.
         * @var array|string[]
         */
        protected static array $routesMap = ['Generic' => 'view'];


        /**The body folder allows to find the directory given to a controller to
         * display the correct HTMLs during the execution of a controller's actions.
         * @var string
         */
        protected static string $bodyFolder = '/Generic';

        /**Returns routes map associated with the corresponding Controller.
         * @return array|string[]
         */
        protected function getRoutesMap(): array {
            return static::$routesMap;
        }

        /**Returns the folder directory with mostly HTML body files
         * associated with the corresponding Controller.
         * @return string
         */
        protected function getBodyFolder(): string
        {
            return static::$bodyFolder;
        }

        /**Get action based on $route if it's found on the routes map.
         * If $route isn't found in routes map, the default action
         * 'view' will be returned instead
         * @param string $route
         * @return string
         */
        public function getRequestedAction(string $route) : ?string {
                $routesMap = $this->getRoutesMap();
                $action = $routesMap[$route] ?? null;
                return $action;
        }

        /**Execute controller action found with getRequestedAction with route
         * (which returns default action 'view' if route is not found).
         * @param string $route
         * @return void
         */
        public function executeAction(string $route): void
        {
            try {
                $action = $this->getRequestedAction($route);
                ExceptionHandler::checkTrueValue(!is_null($action), 404);
                $this->$action();
            } catch (Exception $e) {
                (new ControllerGeneric())->error($e);
            }
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


        /**Main view action method for each controller using displayView.
         * Every controller can use it as long as they have $bodyFolder redefined properly,
         * which is used to obtain the pageTitle and pathViewBody
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
         * ExceptionHandler class checking methods to efficiently catch exceptions
         * @param Exception $e
         * @return void
         */
        public function error(Exception $e): void
        {
            $errorCode = $e->getCode();
            $errorMessage = ExceptionHandler::getErrorMessage($errorCode);
            $this->displayView("Erreur", "/../error404.php",
                ["errorMessage" => $errorMessage]);
        }
    }