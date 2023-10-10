<?php

    namespace App\Web\Model\Repository;

    use App\Web\Model\API\APIConnection;
    use App\Web\Config\ExceptionHandler;
    use App\Web\Model\DataObject\Taxa;
    use Exception;

    class TaxaRepository
    {
        public static function Construire(array $taxaArray): Taxa
        {
            return new Taxa(
                $taxaArray['id'],
                $taxaArray['parentId'],
                $taxaArray['scientificName'],
                $taxaArray['authority'],
                $taxaArray['rankId'],
                $taxaArray['rankName'],
                $taxaArray['habitat'],
                $taxaArray['genusName'],
                $taxaArray['familyName'],
                $taxaArray['orderName'],
                $taxaArray['className'],
                $taxaArray['phylumName'],
                $taxaArray['kingdomName'],
                $taxaArray['taxrefVersion'],
                $taxaArray['_links']
            );
        }

        public static function error(Exception $e): string
        {
            $errorCode = $e->getCode();
            return ExceptionHandler::getErrorMessage($errorCode);
        }

        public static function obtenirTaxaParID(int $id): Taxa|string
        {
            try {
                // Requête envers l'API
                $apiUrl = APIConnection::getApiURL() . "/taxa/$id";
                // Obtenir en string le fichier JSON fourni par l'API
                $reponse = @file_get_contents($apiUrl, false, null);
                ExceptionHandler::checkTrueValue($reponse, 101);
                // Décoder le JSON réçu par l'API
                $data = json_decode($reponse, true);
                ExceptionHandler::checkTrueValue([!isset($data['_embedded']), !is_null($data)], 102);
                // Retourner le taxon si tout est bon
                return self::Construire($data);
            } catch (Exception $e) {
                return static::error($e);
            }
        }


    }