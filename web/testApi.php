<?php
    require_once(__DIR__ . '/../src/Lib/Psr4AutoloaderClass.php');

    use App\Web\Model\API\TaxaAPI;
    use App\Web\Model\Repository\UserRepository;
    use App\Web\Model\DataObject\Taxa;
    use App\Web\Model\DataObject\User;
    use App\Web\Lib\PasswordManager;
    /*
     * L'autoloader nous permettra d'utiliser nos différentes classe
     * de manière plus optimisée (pas besoin de require_once
     * Arborescence namespace :
     * App\Web\Config pour le fichier de configuration
     * App\Web\Model pour les fichiers modèle (back-end surtout)
     * App\Web\Controller pour les fichiers controlleurs (lien entre vues et modèles)
     * App\Web\View pour les fichiers vues (HTML, CSS, JS, images...)
     */
    $loader = new App\Web\Lib\Psr4AutoloaderClass();
    $loader->addNamespace('App\Web', __DIR__ . '/../src');
    $loader->register();

    $user = UserRepository::selectWithId(1);

    $mdp = 'JesusATM12';
    echo PasswordManager::verifyPassword($mdp, $user->getUsername());

    $user = new User('1', 'mail', 'username', 'password', 'role');
    echo $user;
