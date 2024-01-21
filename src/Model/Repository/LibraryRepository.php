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


        protected function Build(array $arrayData): Library|bool
        {
            if (empty($arrayData)) return false;
            else return new Library(...array_values($arrayData));
        }

        protected function GetColumnsNames(): array
        {
            return ["id_lib", "id_creator", "title", "description"];
        }

        public static function BuildWithForm(array $inputArray) : Library
        {
            $id_user = $inputArray['id_creator'];
            $title = $inputArray['title'];
            $description = $inputArray['description'];
            return new Library(null, $id_user, $title, $description);
        }

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