<?php
    require_once(__DIR__ . '/src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Code\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Code', __DIR__ . '/src');
    $loader->register();

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $uri = str_replace('/Orissa', '', $uri);

    $routes = [
        '/Home' => 'src/View/home.php',
        '/Login' => 'src/View/Login/login.php',
    ];

    if (array_key_exists($uri, $routes)){
        require $routes[$uri];
    } else {
        require($routes['/Home']);
    }
    controllerActionHandling();

    function controllerActionHandling() : void {
        if (isset($_GET['controller'])) {
            $controller = $_GET['controller'];
            $controllerClassName = 'App\Web\Controller\Controller' . ucwords($controller);
            var_dump($controllerClassName);
            if (class_exists($controllerClassName)) {
                var_dump(class_exists($controllerClassName));
                if (isset($_GET['action'])) {
                    $action = $_GET['action'];
                    $URLidentifier = (new $controllerClassName())->GetURLIdentifier();
                    $identifier = $_GET[$URLidentifier] ?? null;

                    if (method_exists($controllerClassName, $action)) {
                        (new $controllerClassName())->$action($identifier);
                    }
                }
            }
        }
    }
