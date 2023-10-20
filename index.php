<?php
    use App\Code\Controller\ControllerHome;

    require_once(__DIR__ . '/src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Code\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Code', __DIR__ . '/src');
    $loader->register();

    controllerActionExecution();

    function controllerActionExecution() : void {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
            $uri = str_replace('/Orissa/', '', $uri);
            $uriParts = explode('/', $uri);
            $controllerClassName = $uriParts[0];
            $route = $uriParts[1] ?? 'default';
            $controllerClassName = 'App\Code\Controller\Controller' . ucwords($controllerClassName);
            if (class_exists($controllerClassName)) {
                $controller =  new $controllerClassName();
                $controller->executeAction($route);
            }
            else {
                var_dump("Class doesn't exist");
                (new ControllerHome())->executeAction('Home');
            }
        }
        else {
            (new ControllerHome())->executeAction('Home');
        }
    }