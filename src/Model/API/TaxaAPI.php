<?php

    namespace App\Code\Model\API;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Model\DataObject\Taxa;
    use Exception;

    class TaxaAPI
    {
        /**
         * Builds a Taxa instance from an array that contains all of its necessary data.
         * Use SelectWithID to comfortably build a Taxa with the API with just the ID.
         * All data can be null except for the ID.
         * @param array $taxaArray Array of data for a taxa
         * @return Taxa Built taxa instance
         */
        public static function Build(array $taxaArray): Taxa
        {
            $constructorArray = [];
            foreach ($taxaArray as $key => $attribute)
            {
                if (in_array($key, Taxa::$dataFilterArray))
                {
                    $constructorArray[] = $attribute;
                }
            }
            return new Taxa(...$constructorArray);
        }

        /**
         * Send a request to the API with the API URL, returning
         * often a JSON string file which should be decoded with DecodeJSONFile().
         * If the request fails, return false instead.
         *
         * @param string $apiUrl GetApiURL() from APIConnection
         * should be used for the first part of the URL
         * @return string|false Contents of the API response
         */
        public static function GetAPIResponse(string $apiUrl) : string|false
        {
            // Get JSON file as a string
            $response = @file_get_contents($apiUrl, false, null);
            if (!$response){
                return false;
            }
            return $response;
        }

        /**
         * Decode the JSON string file obtained from an API response, returning
         * an array which allows to handle data more easily.
         * GetAPIResponse() should be used to obtain the JSON file.
         * If the decoding fails, return false.
         * @param string $jsonFile
         * @return array|false
         */
        public static function DecodeJSONFile(string $jsonFile) : array|false
        {
            // Decode JSON string into array
            $data = json_decode($jsonFile, true);
            if (!is_array($data)){
                return false;
            }
            return $data;
        }

        public static function SelectWithID(int $id): Taxa|false
        {
            try {
                // Requête envers l'API
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$id";
                // Get date from API request
                $response = self::GetAPIResponse($apiUrl);
                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkTrueValue(is_array($data),303);
                return self::Build($data);
            } catch (Exception $e) {
                return false;
            }
        }
        public static function SelectFirstAutocomplete(string $name) : Taxa|false
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/autocomplete?term=$name&page=1&size=1";
                $response = self::GetAPIResponse($apiUrl);
                ExceptionHandler::checkTrueValue($response, 303);

                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkTrueValue(isset($data["_embedded"]), 303);

                $taxaData = $data["_embedded"]["taxa"][0];
                return self::SelectWithID($taxaData["id"]);
            } catch (Exception $e){
                return false;
            }
        }

        public static function SelectAutocomplete(string $name, int $size) : array|false
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/autocomplete?term=$name&page=1&size=$size";
                $response = self::GetAPIResponse($apiUrl);
                ExceptionHandler::checkTrueValue($response, 303);

                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkTrueValue(isset($data["_embedded"]), 303);
                $dataArray = $data["_embedded"]["taxa"];

                $taxaResults = [];
                foreach ($dataArray as $taxaArray) {
                    $taxaResults[] = self::SelectWithID($taxaArray['id']);
                }

                return $taxaResults;
            } catch (Exception) {
                return false;
            }
        }

        public static function SearchVernacular(string $name, int $size) : array|false
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/search?frenchVernacularNames=$name&page=1&size=$size";
                $response = self::GetAPIResponse($apiUrl);
                ExceptionHandler::checkTrueValue($response, 303);

                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkTrueValue(isset($data["_embedded"]), 303);
                $dataArray = $data["_embedded"]["taxa"];

                $taxaResults = [];
                foreach ($dataArray as $taxaArray) {
                    if ($taxaArray['parentId'] == null)
                        continue;
                    $taxaResults[] = self::Build($taxaArray);
                }
                return $taxaResults;
            } catch (Exception) {
                return false;
            }
        }

        public static function GetTaxaFactsheet(int|Taxa $taxa) : array|false
        {
            try {
                if ($taxa instanceof Taxa){
                    $taxa = $taxa->getId();
                }
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$taxa/factsheet";

                $response = self::GetAPIResponse($apiUrl);
                ExceptionHandler::checkTrueValue(is_string($response), 303);

                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkTrueValue(is_array($data), 303);

                return $data;
            } catch (Exception $e) {
                return false;
            }
        }
    }