<?php

    namespace App\Code\Lib;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Controller\ControllerGeneric;
    use Exception;

    class Router
    {
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
            $controllerClassName = 'App\Code\Controller\Controller' . $controllerClassName;
            if (class_exists($controllerClassName)){
                return new $controllerClassName;
            }
            else return null;
        }

        private static function getRoute(array $uriController) : ?string {
            $route = "";
            for ($i = 1; $i < sizeof($uriController); $i++){
                $routePart = $uriController[$i];
                $route .= $routePart . "/";
            }
            $route = substr($route, 0, strlen($route) - 1);
            return $route;
        }
    }