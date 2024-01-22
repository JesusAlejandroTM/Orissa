<?php

    namespace App\Code\Model\API;

    use App\Code\Config\ExceptionHandler;
    use App\Code\Model\DataObject\Taxa;
    use Exception;

    class TaxaAPI
    {
        /** Array of allowed characters to launch a search
         * @var array|string[]
         */
        private static array $allowed_chars = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n",
            "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "-"];

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

        /**
         * Check if the input is a Taxa instance or an ID, and return the ID.
         * @param int|Taxa $taxa Taxa instance or ID
         * @return int ID of the Taxa
         */
        private static function CheckTaxaInput(int|Taxa $taxa) : int
        {
            if ($taxa instanceof Taxa) {
                $taxa = $taxa->getId();
            }
            return $taxa;
        }

        /**
         * Check if the input is a string that contains only allowed characters.
         * @param string $string String to check
         * @return bool true if the string contains only allowed characters, false otherwise
         */
        public static function checkAllowedChars(string $string) : bool
        {
            try {
                for ($i = 0; $i < strlen($string); $i++) {
                    $char = $string[$i];
                    ExceptionHandler::checkIsTrue(in_array($char, self::$allowed_chars), 303);
                }
                return true;
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Execute an API request, returning the data as an array.
         * @param $apiUrl string URL of the API request
         * @return array|false Array of data if the request is successful, false otherwise
         */
        private static function ExecuteAPIRequest($apiUrl) : array|false
        {
            try {
                $response = self::GetAPIResponse($apiUrl);
                ExceptionHandler::checkIsTrue(is_string($response), 303);

                $data = self::DecodeJSONFile($response);
                ExceptionHandler::checkIsTrue(is_array($data), 303);
                return $data;
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Select a Taxa instance from the API with its ID.
         * @param int $id ID of the Taxa
         * @return Taxa|false Taxa instance if the request is successful, false otherwise
         */
        public static function SelectWithID(int $id): Taxa|false
        {
            try {
                // Requête envers l'API
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$id";
                // Get date from API request

                $data = self::ExecuteAPIRequest($apiUrl);
                if (!$data) return false;
                return self::Build($data);
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Select a Taxa instance from the API with its name.
         * @param string $name Name of the Taxa
         * @return Taxa|false Taxa instance if the request is successful, false otherwise
         */
        public static function SelectFirstAutocomplete(string $name) : Taxa|false
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/autocomplete?term=$name&page=1&size=1";

                $data = self::ExecuteAPIRequest($apiUrl);

                $taxaData = $data["_embedded"]["taxa"][0];
                return self::SelectWithID($taxaData["id"]);
            } catch (Exception){
                return false;
            }
        }

        /**
         * Launch a search on the API with a name which will be autocompleted, returning a list of Taxa instances.
         * @param string $name Name to search
         * @param int $size Size of the list
         * @return array|false Array of Taxa instances if the request is successful, false otherwise
         */
        public static function SearchAutocompleteList(string $name, int $size) : array|false
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/autocomplete?term=$name&page=1&size=$size";

                $data = self::ExecuteAPIRequest($apiUrl);

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

        /**
         * Launch a search on the API with a name, returning a list of Taxa instances.
         * @param string $name Name to search
         * @param int $size Size of the list
         * @return array|false Array of Taxa instances if the request is successful, false otherwise
         */
        public static function SearchVernacularList(string $name, int $size) : array|false
        {
            try {
                $name = str_replace(" ","%20", $name);
                $apiUrl = APIConnection::GetApiURL() . "/taxa/search?frenchVernacularNames=$name&page=1&size=$size";
                $data = self::ExecuteAPIRequest($apiUrl);
                if ($data['page']['totalElements'] == 0 || !$data || is_null($data)) return false;

                $dataArray = $data["_embedded"]["taxa"];
                $returnResult = [];
                foreach ($dataArray as $taxaArray) {
                    if ($taxaArray['parentId'] == null)
                        continue;
                    $returnResult[] = self::Build($taxaArray);
                }
                if (!$returnResult) return false;
                return $returnResult;
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Launch a search on the API with a name, returning the JSON response as a string.
         * @param string $name Name to search
         * @param int $size Size of the list
         * @return string|false JSON string if the request is successful, false otherwise
         */
        public static function SearchVernacularListJSON(string $name, int $size) : string|false
        {
            try {
                $name = str_replace(" ","%20", $name);
                $apiUrl = APIConnection::GetApiURL() . "/taxa/search?frenchVernacularNames=$name&page=1&size=$size";
                $data = self::ExecuteAPIRequest($apiUrl);
                if ($data['page']['totalElements'] == 0 || !$data) return false;
                $dataArray = $data["_embedded"]["taxa"];
                $results = [];
                foreach ($dataArray as $taxa)
                {
                    if ($taxa['parentId'] == null)
                        continue;
                    $taxaId = $taxa['id'];
                    $taxaName = $taxa['frenchVernacularName'];
                    $taxaImg = $taxa['_links']['media']['href'] ?? null;
                    $taxaData = ["taxaId" => $taxaId, "taxaName" => $taxaName, "taxaImg" => $taxaImg];
                    $results[] = $taxaData;
                }
                return json_encode($results);
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Get the factsheet of a Taxa instance from the API.
         * @param int|Taxa $taxa Taxa instance or ID
         * @return array|false Array of data if the request is successful, false otherwise
         */
        public static function GetTaxaFactsheet(int|Taxa $taxa) : array|false
        {
            try {
                $taxa = self::CheckTaxaInput($taxa);
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$taxa/factsheet";
                return self::ExecuteAPIRequest($apiUrl);
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Get the interactions of a Taxa instance from the API.
         * @param int|Taxa $taxa Taxa instance or ID
         * @return array|false Array of interactions if the request is successful, false otherwise
         */
        public static function GetTaxaInteractions(int|Taxa $taxa) : array|false
        {
            try {
                $taxa = self::CheckTaxaInput($taxa);
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$taxa/interactions";
                return self::ExecuteAPIRequest($apiUrl);
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Get the media links of a Taxa instance from the API.
         * @param int $idTaxa ID of the Taxa
         * @return array|null Array of media links if the request is successful, null otherwise
         */
        public static function GetTaxaMedia(int $idTaxa) : array|null
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$idTaxa/media";
                return self::ExecuteAPIRequest($apiUrl);
            } catch (Exception) {
                return null;
            }
        }

        /**
         * Get the image link of a Taxa instance from the API.
         * @param int $idTaxa ID of the Taxa
         * @return mixed the image link if the request is successful, false otherwise
         */
        public static function GetTaxaImage(int $idTaxa) : mixed
        {
            try {
                $taxaMedia = self::GetTaxaMedia($idTaxa);
                return $taxaMedia['_embedded']['media'][0]['_links']['file']['href'] ?? false;
            } catch (Exception) {
                return false;
            }
        }

        /**
         * Get the status of a Taxa instance from the API.
         * @param int $idTaxa ID of the Taxa
         * @return array|null Array of status data if the request is successful, null otherwise
         */
        public static function GetTaxaStatus(int $idTaxa) : array|null
        {
            try {
                $apiUrl = APIConnection::GetApiURL() . "/taxa/$idTaxa/status/columns";
                $result = self::ExecuteAPIRequest($apiUrl);
                return $result['_embedded']['status'][0] ?? null;
            } catch (Exception) {
                return null;
            }
        }

        /**
         * Get a random Taxa instance from the API.
         * @return int|false ID of the Taxa if the request is successful, false otherwise
         */
        public static function GetRandomTaxa() : int|false
        {
            $alphabetSet = range('a', 'z');
            $randomIndex = array_rand($alphabetSet);
            $randomCharacter = $alphabetSet[$randomIndex];
            $taxaResults = self::SearchVernacularList($randomCharacter, 100);
            $taxaRandomIndex = array_rand($taxaResults);
            $randomTaxa = $taxaResults[$taxaRandomIndex];
            return $randomTaxa->getId();
        }

        /**
         * Get the list of biogeographic status from the API.
         * @return array|null Array of biogeographic status if the request is successful, null otherwise
         */
        public static function GetBiogeographicStatusList() : array|null
        {
            $apiUrl = APIConnection::GetApiURL() . "/biogeographicStatus";
            $result = self::ExecuteAPIRequest($apiUrl);
            return $result['_embedded'] ?? null;
        }
    }