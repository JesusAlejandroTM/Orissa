<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Model\API\TaxaAPI;
    use Exception;

    class ControllerTaxa extends AbstractController
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Taxa' => 'view',
            'Taxa/:param:' => 'viewTaxa',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Taxa';

        protected function viewTaxa(int $taxaIdParameter): void
        {
            //TODO Parameterized URIs are done, implement Taxa search
            try {
                $this->displayView("Taxas found", "/taxa.php",
                    ["nan.css"], ["taxaId" => $taxaIdParameter]);
            } catch (Exception $e) {
                FlashMessages::add("warning", "Ce taxon n'existe pas");
                header("Location: /Orissa/Search");
                exit();
            }
        }
    }