<?php
    use App\Code\Controller\ControllerHome;
    use App\Code\Lib\Router;

    require_once(__DIR__ . '/src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Code\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Code', __DIR__ . '/src');
    $loader->register();

    Router::controllerActionExecution();