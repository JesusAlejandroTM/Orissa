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

        public function view() : void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpFile = '/' . strtolower($title) . '.php';
            //FIXME MAKE A CSS FILE BY DEFAULT FOR VIEWS?
            $this->displayView($title, $phpFile,  ['home/homeMobile.css', 'home/home.css']);
        }

        public function discoverTaxa()
        {
            $taxaId = TaxaAPI::GetRandomTaxa();
            header("Location: /Orissa/Taxa/$taxaId");
        }
    }