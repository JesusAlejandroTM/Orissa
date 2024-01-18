<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Lib\UserSession;
    use Exception;

     /**AbstractController is the parent controller which allows to create child controllers with dynamic
     * and flexible methods. Every child controller must redefine $routesMap and $bodyFolder to function
     * properly. A controller is associated with a folder under the View directory, for example a controller
     * who manages the login system should be called ControllerLogin and have a Login folder under the View
     * directory so classes, actions and files can be found.
     * To extend AbstractController into child controllers, you can redefine $routesMap and $bodyFolder and
     * create the actions like this :
     *
     *      // Extending AbstractController :
     *
     *      class ControllerLogin extends AbstractController {
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
     *          $this->displayView("Logging", "/login.php");
     *          }
     *      }
     *
     *      
     */
    abstract class AbstractController
    {
        /**The routes map allows to control actions that are defined in the array
         * and execute methods accordingly. They are associated with a corresponding
         * controller, every controller should have this variable redefined accordingly.
         * @var array|string[]
         */
        protected static array $routesMap;


        /**The body folder allows to find the directory given to a controller to
         * display the correct HTMLs during the execution of a controller's actions.
         * @var string
         */
        protected static string $bodyFolder;

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
         * If $route isn't found in routes map, the action returned is
         * null and will most likely trigger a 404 error.
         * @param string $route
         * @return ?string
         */
        public function getRequestedAction(string $route) : ?string {
            $routesMap = $this->getRoutesMap();
            return $routesMap[$route] ?? null;
        }

        /**
         * Execute controller action found with getRequestedAction with route,
         * if the route is not found redirect the user into a 404 error page instead.
         * @param string $route
         * @param array $parameters
         * @return void
         */
        public function executeAction(string $route, array $parameters = []): void
        {
            try {
                Router::isRouteParameterized($route);
                $action = $this->getRequestedAction($route);
                ExceptionHandler::checkIsTrue(!is_null($action), 404);
                $this->$action(...$parameters);
            } catch (Exception $e) {
                $this->error($e);
            }
        }

        /**
         * Display specific page passed in $pathViewBody into the
         * web interface, this method uses main file view.php to structure HTMLs
         * CSS file names must be passed as arrays to properly iterate over them and
         * link them into the corresponding HTML, dynamically linking CSS files by
         * just calling their file name.
         * @param string $pageTitle
         * @param string $pathViewBody
         * @param array $cssArray
         * @param array $parameters Optional
         * @param array $jsArray
         * @return void
         */
        public function displayView(string $pageTitle, string $pathViewBody, array $cssArray,
                                    array $parameters = [], array $jsArray = []): void
        {
            $defaultCSSArray = ['footer.css', 'header.css', 'alert.css'];
            foreach ($defaultCSSArray as $css) {
                $cssArray[] = $css;
            }

            // We add $pageTitle and $pathViewBody in our parameters array
            $parameters += [
                'pageTitle' => $pageTitle,
                'pathViewBody' => $this->getBodyFolder() . $pathViewBody,
                'cssArray' => $cssArray,
                'jsArray' => $jsArray,
            ];

            extract($parameters); // We extract the variables from our parameters array
            require(__DIR__ . '/../View/view.php'); // Load the view
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
            $phpFile = '/' . strtolower($title) . '.php';
            //FIXME MAKE A CSS FILE BY DEFAULT FOR VIEWS?
            $this->displayView($title, $phpFile,  []);
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
            //FIXME Default CSS missing
            $this->displayView("Erreur", "/../error.php", ["NaN.css"],
                ["errorMessage" => $errorMessage]);
        }

        protected function CheckUserAccess() : bool
        {
            $username = UserSession::isConnected();
            if (!$username) {
                FlashMessages::add("warning", "You must be logged in to access this page");
                header("Location: /Orissa/Home");
                return false;
            }
            return true;
        }
    }