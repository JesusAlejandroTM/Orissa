<?php

    use App\Code\Controller\ControllerLogin;
    use App\Code\Controller\Router;
    use App\Code\Model\Repository\UserRepository;
    use App\Code\Model\API\TaxaAPI;

    require_once(__DIR__ . '/src/Lib/Psr4AutoloaderClass.php');

    $loader = new App\Code\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Code', __DIR__ . '/src');
    $loader->register();

    Router::controllerActionExecution();
