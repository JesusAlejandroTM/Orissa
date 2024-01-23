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

        /**Search Controller's definition of search body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Search';

        /**
         * Displays the search page
         * @return void
         */
        public function view(): void
        {
            $string = $this->getBodyFolder();
            $title = explode('/', $string)[1];
            $phpFile = '/' . strtolower($title) . '.php';
            $this->displayView($title, $phpFile,  ['search/search.css', 'loaderCreateLibrary.css'],
                [], ['taxaSearch.js', 'apiDataProcesses.js']);
        }

        /**
         * Searches for taxas with the given name
         * If no taxas are found, redirects to the search page with a warning message
         * @return void
         */
        protected function SearchTaxas(): void
        {
            try {
                $searchInput = $_GET["taxaName"];
                ExceptionHandler::checkisTrue(TaxaAPI::checkAllowedChars($searchInput), 304);

                $result = TaxaAPI::SearchVernacularList($searchInput, 100);
                ExceptionHandler::checkIsTrue(is_array($result), 303);
                $this->displayView("Taxas found", "/search.php",
                    ["search/search.css"], ['taxaArrays' => $result]);
            } catch (Exception $e) {
                if ($e->getCode() == 303) {
                    FlashMessages::add("warning", "Pas de taxons trouvés avec : " . $searchInput);
                    header("Location: /Orissa/Search");
                }
                else if ($e->getCode() == 304) {
                    FlashMessages::add("warning", "Les caractères spéciaux ne sont pas autorisés");
                    header("Location: /Orissa/Search");
                }
                else {
                    FlashMessages::add("warning", "Une erreur est survenue");
                    header("Location: /Orissa/Search");
                }
                exit();
            }
        }
    }