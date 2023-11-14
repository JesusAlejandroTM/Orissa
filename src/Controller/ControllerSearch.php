<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Model\API\TaxaAPI;
    use Exception;

    class ControllerSearch extends AbstractController
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Search' => 'view',
            'Search/SearchTaxas' => 'SearchTaxas'
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Search';

        protected function SearchTaxas(): void
        {
            try {
                $searchInput = $_GET["taxaName"];
                $result = TaxaAPI::SearchVernacular($searchInput, 10);
                ExceptionHandler::checkTrueValue(is_array($result), 303);
                $this->displayView("Taxas found", "/search.php",
                    ["nan.css"], ['taxaArrays' => $result]);
            } catch (Exception $e) {
                FlashMessages::add("warning", "Pas de taxons trouvés avec : " . $searchInput);
                header("Location: /Orissa/Search");
                exit();
            }
        }
    }