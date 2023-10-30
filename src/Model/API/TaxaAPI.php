<?php

    namespace App\Web\Model\API;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Model\DataObject\Taxa;
    use Exception;

    class TaxaAPI
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
                $taxaArray['taxRefVersion'],
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
                // Send request to API
                $apiUrl = APIConnection::getApiURL() . "/taxa/$id";
                // Obtain JSON string of returned request
                $response = @file_get_contents($apiUrl, false, null);
                ExceptionHandler::checkTrueValue($response, 101);
                // Decode the JSON string
                $data = json_decode($response, true);
                ExceptionHandler::checkTrueValue([!isset($data['_embedded']), !is_null($data)], 102);
                // Return taxa object
                return self::Construire($data);
            } catch (Exception $e) {
                return static::error($e);
            }
        }


    }