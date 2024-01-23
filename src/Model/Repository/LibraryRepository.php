<?php

    namespace App\Code\Model\Repository;

    use App\Code\Model\DataObject\Library;

    class LibraryRepository extends AbstractRepository
    {
        protected function GetPrimaryKeyColumn(): string
        {
            return "id_lib";
        }

        protected function GetTableName(): string
        {
            return "library";
        }


        /**
         * Build a Library object from an array of data
         * @param array $arrayData the array of data
         * @return Library|bool the Library object built or false if an error occurred
         */
        protected function Build(array $arrayData): Library|bool
        {
            if (empty($arrayData)) return false;
            else return new Library(...array_values($arrayData));
        }

        protected function GetColumnsNames(): array
        {
            return ["id_lib", "id_creator", "title", "description"];
        }

        /**
         * Build a Library object from a form input array
         * @param array $inputArray the input array from a form
         * @return Library the Library object built
         */
        public static function BuildWithForm(array $inputArray) : Library
        {
            $id_user = $inputArray['id_creator'];
            $title = $inputArray['title'];
            $description = $inputArray['description'];
            return new Library(null, $id_user, $title, $description);
        }

        /**
         * Get all libraries from a user id
         * @param int $userId the id of the user
         * @return array|bool an array of Library objects or false if an error occurred
         */
        public static function getUserLibraries(int $userId) : array|bool
       {
           $sql = 'SELECT * FROM library WHERE id_creator = :idTag;';
           $results = self::SingleDataGetter($userId, $sql);
           if (is_array($results)) {
               foreach ($results as $key => $data) {
                   $results[$key] = (new LibraryRepository)->Build($data);
               }
           } else return false;
           return $results;
       }

        /**
         * Insert a library object in the database and return its id
         * @param Library $library the library object to insert
         * @return bool|int false if an error occurred, the id of the library otherwise
         */
        public function insertGetLastId(Library $library) : bool|int
       {
           $result = $this->Insert($library);
           if ($result === true)
           {
               return DatabaseConnection::getPdo()->lastInsertId();
           }
           else return false;
       }

    }