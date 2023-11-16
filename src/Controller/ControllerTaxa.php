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
            'Taxa/:id:' => 'viewTaxa',
            'Taxa/:id:/factsheet',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Taxa';

        protected function viewTaxa(int $taxaID): void
        {
            try {
                $this->displayView("Taxas found", "/search.php",
                    ["nan.css"]);
            } catch (Exception $e) {
                FlashMessages::add("warning", "Ce taxon n'existe pas");
                header("Location: /Orissa/Search");
                exit();
            }
        }
    }