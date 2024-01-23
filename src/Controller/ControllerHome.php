<?php

    namespace App\Code\Controller;

    use App\Code\Model\API\TaxaAPI;

    class ControllerHome extends AbstractController
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Home' => 'view',
            'Home/Discovery' => 'discoverTaxa',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Home';

        /**
         * Displays the home page
         * @return void
         */
        public function view() : void
        {
            //FIXME MAKE A CSS FILE BY DEFAULT FOR VIEWS?
            $this->displayView('Orissa', '/home.php',  ['home/homeMobile.css', 'home/home.css']);
        }

        /**
         * Redirects to a random taxa page
         * @return void
         */
        public function discoverTaxa()
        {
            $taxaId = TaxaAPI::GetRandomTaxa();
            header("Location: /Orissa/Taxa/$taxaId");
        }
    }