<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use Exception;

    /** Router takes in charge handling requests by the User
     *  through the URI. The router reads the URI and checks
     *  whether the route read from the URI exists or not.
     *  The first path will always be Orissa as it is the website
     *  itself. The second path will always be a controller which
     *  will take in charge the actions of said route.
     *  The rest of the paths will be defined in the routesMap
     *  of the associated Controller.
     *
     *  For example, the route : /Orissa/Login/Logging
     *
     *     /    Orissa     /   Login     /        Logging
     *            ^              ^                   ^
     *        First path    Second Path          Third Path
     *         Website      Controller    Action for said Controller
     */
    class Router
    {
        /**Main method which executes an action based on the URI using the multiple methods
         * @return void
         */
        public static function controllerActionExecution() : void {
            try {
                $parameterizedUri = self::transformNumericParams();
                $parameters = self::getUriNumericParameters();
                $controller = self::getController($parameterizedUri);
                ExceptionHandler::checkTrueValue($controller instanceof AbstractController, 404);
                $route = self::getRoute($parameterizedUri);
                $controller->executeAction($route, $parameters);
            } catch (Exception $e) {
                (new ControllerHome())->error($e);
            }
        }

        /**
         * Gets the different parts of a URI from the URL
         * passed by the user. The different parts of the URI
         * correspond to a route which leads which action
         * will be executed by the controller.
         * @return array|null An array of paths corresponding to a route.
         * For example, this URL : "/Orissa/Login/Create" returns the array :
         * [0 => 'Orissa', 1 => 'Login', 2 => 'Create']
         */
        public static function getUriParts() : ?array
        {
            // Check for the URL, should always be true
            if (isset($_SERVER['REQUEST_URI'])) {
                // Get the URL from our request URI
                $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
                // Remove the first slash in the array
                $uri = substr($uri, 1, strlen($uri) - 1);
                // Return an array of the different paths
                return explode('/', $uri);
            }
            else return null;
        }

        /**
         * Transform the URI parts considered as parameters into default
         * parameter name ":param:", allowing for parameterizing dynamic
         * URL requests.
         * @return array Returns the transformed array with the new
         * parameter names, for example : ["Orissa", "Login", ":param:"]
         */
        public static function transformNumericParams() : array
        {
            $uriParts = Router::getUriParts();
            for ($i = 0; $i < sizeof($uriParts); $i++)
            {
                $part = $uriParts[$i];
                if (is_numeric($part)) {
                    $uriParts[$i] = ":param:";
                }
            }
            return $uriParts;
        }

        /**
         * Get all the numeric values found in the URI which should only be
         * used for dynamic URL redirecting. Any numeric value found in the
         * URI will be considered as an error and surely causing an error.
         * @return array|null An array of numeric parameters found in the URL
         * For example : in 'Orissa/Taxa/545/Factsheet/153', we get : [545, 153]
         */
        public static function getUriNumericParameters(): ?array
        {
            $uriParts = Router::getUriParts();
            $uriParameters = [];
            foreach ($uriParts as $item) {
                if (is_numeric($item)) {
                    $uriParameters[] = $item;
                }
            }
            if (empty($uriParameters)) return null;
            return $uriParameters;
        }

        public static function isRouteParameterized($url) : bool
        {
            $parameterName = "/:param:/";
            $result = preg_match($parameterName, $url);
            if ($result == 1) return true;
            else return false;
        }

        /**
         * Get the controller based on the name of the second
         * path found from the passed array. This means the second path
         * should always be the name of a controller class or an error will occur.
         * @param array $uriPath The array corresponding to a URL path.
         * For illustration : [0 => 'Orissa', 1 => 'Login', 2 => 'Create'].
         * @return AbstractController|null The instance of a controller
         * inherited by ControllerGeneric. For example, passing the array above
         * will return an instance of ControllerLogin.
         */
        private static function getController(array $uriPath) : ?AbstractController {
            // Get the name of the controller class in index 1
            $controllerClassName = $uriPath[1];
            // If it's empty, default controller is Home
            if ($uriPath[1] == ''){
                $controllerClassName = 'Home';
            }
            // Get the entire name of the class, including namespace
            $controllerClassName = 'App\Code\Controller\Controller' . $controllerClassName;
            // Check if the class exists
            if (class_exists($controllerClassName)){
                return new $controllerClassName;
            }
            // Else return null, creating an error
            else return null;
        }

        /**
         * Make a string of the route based on the URI Path array.
         * Esentially removes the "Orissa" from the Uri and converts it
         * into a string, also checks if the URI is null to return default
         * route Home
         * @param array $uriPath
         * @return string|null
         */
        private static function getRoute(array $uriPath) : ?string {
            $route = "";
            if ($uriPath[1] == ''){
                return 'Home';
            }
            for ($i = 1; $i < sizeof($uriPath); $i++){
                $routePart = $uriPath[$i];
                $route .= $routePart . "/";
            }
            return substr($route, 0, strlen($route) - 1);
        }
    }