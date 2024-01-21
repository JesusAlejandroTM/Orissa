<?php

    namespace App\Code\Controller;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Lib\FlashMessages;
    use App\Code\Model\API\TaxaAPI;
    use App\Code\Model\Repository\TaxaRegisters;
    use Exception;

    class ControllerTaxa extends AbstractController
    {
        /**Home Controller's definition of routes Map
         * @var array|string[]
         */
        protected static array $routesMap = [
            'Taxa' => 'view',
            'Taxa/:param:' => 'viewTaxa',
            'Taxa/:param:/factsheet' => 'viewTaxaFactsheet',
            'Taxa/:param:/interactions' => 'viewTaxaInteractions',
            'Taxa/:param:/register' => 'registerSelectedTaxa',
            'Taxa/:param:/unregister' => 'unregisterSelectedTaxa',
        ];

        /**Home Controller's definition of Home body's folder directory
         * @return string
         */
        protected static string $bodyFolder = '/Taxa';

        protected function viewTaxa(int $idTaxa): void
        {
            try {
                $taxa = TaxaAPI::SelectWithID($idTaxa);
                ExceptionHandler::checkIsTrue($taxa, 203);
                $taxaImage = TaxaAPI::GetTaxaImage($idTaxa);
                $taxaStatus = TaxaAPI::GetTaxaStatus($idTaxa);
                $this->displayView("Taxas found", "/selectTaxa.php",
                    ["taxa/taxa.css"], ["taxa" => $taxa, "taxaImage" => $taxaImage, "taxaStatus" => $taxaStatus]);
            } catch (Exception $e) {
                $errorMessage = ExceptionHandler::getErrorMessage($e->getCode());
                FlashMessages::add("danger", $errorMessage);
                header("Location: /Orissa/Search");
                exit();
            }
        }

        protected function viewTaxaFactsheet(int $taxaIdParameter) : void
        {
            try {
                $factsheet = TaxaAPI::GetTaxaFactsheet($taxaIdParameter);
                if (!$factsheet) {
                    throw new Exception("Ce taxon n'a pas de fiche d'informations disponible", 204);
                }
                $this->displayView("Taxa factsheet", "/factsheet.php",
                    ["taxa/factsheet.css"], ["factsheet" => $factsheet, "taxaId" => $taxaIdParameter]);
            } catch (Exception $e) {
                if ($e->getCode() == 204) {
                    $exceptionMessage = $e->getMessage();
                    $this->displayView("Taxa factsheet", "/factsheet.php",
                        ["nan.css"], ["exceptionMessage" => $exceptionMessage, "taxaId" => $taxaIdParameter]);
                }
                else {
                    FlashMessages::add("warning", "Ce taxon n'existe pas");
                    header("Location: /Orissa/Taxa");
                    exit();
                }
            }
        }

        protected function viewTaxaInteractions(int $taxaIdParameter) : void
        {
            try {
                $interactions = TaxaAPI::GetTaxaInteractions($taxaIdParameter);
                if (!$interactions) {
                    throw new Exception("Ce taxon n'a pas de fiche d'interactions disponible", 205);
                }
                $this->displayView("Taxa factsheet", "/interactions.php",
                    ["nan.css"], ["interactions" => $interactions, "taxaId" => $taxaIdParameter]);
            } catch (Exception $e) {
                if ($e->getCode() == 205) {
                    $exceptionMessage = $e->getMessage();
                    $this->displayView("Taxa interactions", "/interactions.php",
                        ["nan.css"], ["exceptionMessage" => $exceptionMessage, "taxaId" => $taxaIdParameter]);
                }
                else {
                    FlashMessages::add("warning", "Ce taxon n'existe pas");
                    header("Location: /Orissa/Taxa");
                    exit();
                }
            }
        }

        protected function registerSelectedTaxa(int $taxaIdParameter) : void
        {
            TaxaRegisters::RegisterTaxa($taxaIdParameter);
            FlashMessages::add('success', 'Enregistrement du taxon avec succès');
            header("Location: /Orissa/Taxa/$taxaIdParameter");
        }

        protected function unregisterSelectedTaxa(int $taxaIdParameter) : void
        {
            TaxaRegisters::UnregisterTaxa($taxaIdParameter);
            FlashMessages::add('success', 'Suppression du taxon avec succès');
            header("Location: /Orissa/Taxa/$taxaIdParameter");
        }
    }