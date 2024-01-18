<?php

    namespace App\Code\Controller;

    use App\Code\Lib\UserSession;
    use App\Code\Model\HTTP\Session;

    class ControllerLibrary extends AbstractController
    {
        /**Library Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Library' => 'view',
            'Library/CreateLibrary' => 'displayCreateLibrary',
        ];

        /**Library Controller's definition of Library body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Library';

        public function view(): void
        {
            if (UserSession::isConnected()) $this->displayView("Library", "/library.php",  []);
            else $this->displayView("Library", "/loginError.html",  []);
        }

        protected function displayCreateLibrary(): void
        {
            $this->CheckUserAccess();
            $this->displayView("Create Library", "/createLibrary.php", []);
        }
    }