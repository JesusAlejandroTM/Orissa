<?php

    namespace App\Code\Lib;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Controller\ControllerGeneric;
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
        /**Main method which executes an action
         * @return void
         */
        public static function controllerActionExecution() : void {
            try {
                $uriParts = self::getUriParts();
                $controller = self::getController($uriParts);
                ExceptionHandler::checkTrueValue($controller instanceof ControllerGeneric, 404);
                $route = self::getRoute($uriParts);
                $controller->executeAction($route);
            } catch (Exception $e) {
                (new ControllerGeneric())->error($e);
            }
        }
        private static function getUriParts() : ?array
        {
            if (isset($_SERVER['REQUEST_URI'])) {
                $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
                $uri = substr($uri, 1, strlen($uri) - 1);
                return explode('/', $uri);
            }
            else return null;
        }

        private static function getController(array $uriController) : ?ControllerGeneric {
            $controllerClassName = $uriController[1];
            if ($uriController[1] == ''){
                $controllerClassName = 'Home';
            }
            $controllerClassName = 'App\Code\Controller\Controller' . $controllerClassName;
            if (class_exists($controllerClassName)){
                return new $controllerClassName;
            }
            else return null;
        }

        private static function getRoute(array $uriController) : ?string {
            $route = "";
            if ($uriController[1] == ''){
                return 'Home';
            }
            for ($i = 1; $i < sizeof($uriController); $i++){
                $routePart = $uriController[$i];
                $route .= $routePart . "/";
            }
            return substr($route, 0, strlen($route) - 1);
        }
    }