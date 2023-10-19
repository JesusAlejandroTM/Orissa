<?php
    use App\Code\Controller\ControllerGeneric;

    require_once(__DIR__ . '/src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Code\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Code', __DIR__ . '/src');
    $loader->register();

    $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
    $uri = str_replace('/Orissa', '', $uri);

    $controllerGeneric = new ControllerGeneric();

    $routes = [
        '/Home' => '/../Home/home.php',
        '/Login' => '/../Login/login.php',
    ];

    if (array_key_exists($uri, $routes)){
        $controllerGeneric->afficheVue("Page title", $routes[$uri]);
    } else {
        $controllerGeneric->afficheVue("Default", '/../Home/home.php');
    }
    controllerActionHandling();

    function afficheIndex(){
        require(__DIR__ . '/src/View/view.php');
    }

    function controllerActionHandling() : void {
        if (isset($_GET['controller'])) {
            $controller = $_GET['controller'];
            $controllerClassName = 'App\Code\Controller\Controller' . ucwords($controller);
            if (class_exists($controllerClassName)) {
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
