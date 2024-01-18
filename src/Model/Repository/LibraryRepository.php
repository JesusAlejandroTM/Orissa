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
    }