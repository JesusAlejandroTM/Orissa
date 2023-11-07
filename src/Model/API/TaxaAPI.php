<?php

    namespace App\Code\Model\API;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Model\DataObject\Taxa;
    use Exception;

    class TaxaAPI
    {
        public static function build(array $taxaArray): Taxa
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

        public static function getAPIResponse(string $apiUrl) : string|false {
            // Get JSON file as a string
            $response = @file_get_contents($apiUrl, false, null);
            if (!$response){
                return false;
            }
            return $response;
        }

        public static function decodeJSONFile(string $jsonFile) : array|false {
            // Decode JSON string into array
            $data = json_decode($jsonFile, true);
            if (!$data){
                return false;
            }
            return $data;
        }

        public static function selectWithID(int $id): Taxa|string
        {
            try {
                // Requête envers l'API
                $apiUrl = APIConnection::getApiURL() . "/taxa/$id";
                // Get date from API request
                $response = self::getAPIResponse($apiUrl);
                $data = self::decodeJSONFile($response);
                ExceptionHandler::checkTrueValue(is_array($data),303);
                return self::build($data);
            } catch (Exception $e) {
                return ExceptionHandler::getErrorMessage($e->getCode());
            }
        }
        public static function selectFirstAutocomplete(string $name) : Taxa|string {
            try {
                $apiUrl = APIConnection::getApiURL() . "/taxa/autocomplete?term=$name&page=1&size=1";
                $response = self::getAPIResponse($apiUrl);
                ExceptionHandler::checkTrueValue($response, 303);

                $data = self::decodeJSONFile($response);
                ExceptionHandler::checkTrueValue(isset($data["_embedded"]), 303);

                $taxaData = $data["_embedded"]["taxa"][0];
                return self::selectWithID($taxaData["id"]);
            } catch (Exception $e){
                return ExceptionHandler::getErrorMessage($e->getCode());
            }
        }
    }