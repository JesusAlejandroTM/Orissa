<?php

    namespace App\Code\Model\Repository;

    use App\Code\Model\DataObject\AbstractDataObject;
    use Exception;
    use InvalidArgumentException;
    use LogicException;
    use PDO;
    use PDOException;

    abstract class AbstractRepository
    {
        protected abstract function GetPrimaryKeyColumn(): string;

        protected abstract function GetTableName(): string;

        protected abstract function Build(array $arrayData): AbstractDataObject|bool;

        protected abstract function GetColumnsNames(): array;

        /**
         * Get SQL Columns of corresponding repository
         * @param bool $tagMode set to true if you want the tag version for inputs
         * @return string the SQL Columns of corresponding repository
         */
        public function GetSQLColumns(bool $tagMode = false) : string
        {
            $arrayColonnes = $this->GetColumnsNames();
            if ($tagMode) {
                $setColonnes = '';
                foreach ($arrayColonnes as $colonne) {
                    $setColonnes .=  $colonne . ' = :' . $colonne . 'Tag, ';
                }
                return rtrim($setColonnes, ', ');
            }

            else {
                $return_colonnes = implode(', ', $arrayColonnes);
                return rtrim($return_colonnes, ', ');
            }
        }

        /**
         * Get SQL Columns of corresponding repository without the primary key
         * @param bool $tagMode set to true if you want the tag version for inputs
         * @return string the SQL Columns of corresponding repository without the primary key
         */
        public function GetSQLColumnsWithoutPrimary(bool $tagMode = false) : string
        {
            $arrayColonnes = $this->GetColumnsNames();
            // Remove the first column with is the Primary Key column
            unset($arrayColonnes[0]);
            if ($tagMode) {
                $setColonnes = '';
                foreach ($arrayColonnes as $colonne) {
                    $setColonnes .=  $colonne . ' = :' . $colonne . 'Tag, ';
                }
                return rtrim($setColonnes, ', ');
            }

            else {
                $return_colonnes = implode(', ', $arrayColonnes);
                return rtrim($return_colonnes, ', ');
            }
        }

        /**
         * Get SQL Tags of corresponding repository
         * @return string the SQL Tags of corresponding repository
         */
        private function GetSQLTags() : string
        {
            $arrayColonnes = $this->GetColumnsNames();
            $setColonnes = '';
            foreach ($arrayColonnes as $colonne) {
                $setColonnes .= ':' . $colonne . 'Tag, ';
            }
            return rtrim($setColonnes, ', ');
        }

        /**
         * Get SQL Tags of corresponding repository without the primary key
         * @return string the SQL Tags of corresponding repository without the primary key
         */
        private function GetSQLTagsWithoutPrimary() : string
        {
            $arrayColonnes = $this->GetColumnsNames();
            unset($arrayColonnes[0]);
            $setColonnes = '';
            foreach ($arrayColonnes as $colonne) {
                $setColonnes .= ':' . $colonne . 'Tag, ';
            }
            return rtrim($setColonnes, ', ');
        }


        /**
         * Select all the data from the corresponding repository
         * @return array an array of AbstractDataObject
         */
        public function SelectAll(): array
        {
            $sql = 'SELECT * FROM ' . $this->GetTableName() . ';';
            $pdoStatement = DatabaseConnection::getPdo()->query($sql);
            $fetchData = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            $result = [];
            foreach ($fetchData as $data) {
                $result[] = $this->Build($data);
            }
            return $result;
        }

        /**
         * Select one data from the corresponding repository with its primary key
         * @param string $identifier the primary key of the data to select
         * @return AbstractDataObject|string the data selected or an error message
         */
        public function Select(string $identifier): AbstractDataObject|string
        {
            try {
                $sql = 'SELECT ' . $this->GetSQLColumns() . ' FROM ' . $this->GetTableName() .
                    ' WHERE ' . $this->GetPrimaryKeyColumn() . ' = :' . $this->GetPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->GetPrimaryKeyColumn() . 'Tag' => $identifier);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("$identifier inexistant");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Build($data);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }


        /**
         * Delete one data from the corresponding repository with its primary key
         * @param string $identifier the primary key of the data to delete
         * @return bool|string true if the data has been deleted, false otherwise
         */
        public function Delete(string $identifier): bool|string
        {
            try {
                $sql = 'DELETE FROM ' . $this->GetTableName() .
                    ' WHERE ' . $this->GetPrimaryKeyColumn() . ' = :' . $this->GetPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->GetPrimaryKeyColumn() . 'Tag' => $identifier);

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() == 0) {
                    throw new Exception("$identifier inexistant");
                }
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        /**
         * Update one data from the corresponding repository with its primary key
         * @param AbstractDataObject $objet the data to update with its primary key
         * @return bool|string true if the data has been updated, false otherwise
         */
        public function Update(AbstractDataObject $objet): bool|string
        {
            try {
                $setColonnes = $this->GetSQLColumnsWithoutPrimary(true);

                $sql = 'UPDATE ' . $this->GetTableName() . ' SET ' . $setColonnes .
                    ' WHERE ' . $this->GetPrimaryKeyColumn() . ' = :' . $this->GetPrimaryKeyColumn() . 'Tag;';
                $values = $objet->formatTableau();
                $values = self::unsetEmptyValues($values);

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new LogicException($objet->getPrimaryKeyValue() . ' inexistant');
                }
                return true;
            } catch (LogicException|PDOException $e) {
                return $e->getMessage();
            }
        }

        /**
         * Insert one abstract data object in the corresponding repository with its primary key
         * @param AbstractDataObject $object the data to insert with its primary key
         * @return bool|string true if the data has been inserted, false otherwise
         */
        public function Insert(AbstractDataObject $object) : bool|string {
            try {
                $sql = 'INSERT INTO ' . $this->GetTableName() . ' (' . $this->GetSQLColumnsWithoutPrimary() .
                    ') VALUES ' . '(' . $this->GetSQLTagsWithoutPrimary() . ');';
                $values = $object->formatTableau();
                $values = self::unsetEmptyValues($values);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() < 1){
                    throw new LogicException($object->getPrimaryKeyValue() . 'inexistant');
                }
                return true;
            } catch (LogicException|PDOException $e) {
                return $e->getMessage();
            }
        }

        /**
         * Remove all keys with empty values from an array
         * @param array $values
         * @return array
         */
        private static function unsetEmptyValues(array $values) : array
        {
            foreach ($values as $key => $value)
            {
                if (empty($values[$key]))
                {
                    unset($values[$key]);
                }
            }
            return $values;
        }

        /**
         * Get all the data from the corresponding repository with an id
         * The SQL query will be executed with the id as a parameter
         * @param int $id the id of the data to select
         * @param string $sql the SQL query to execute
         * @return array|bool an array of data or false if an error occurred
         */
        protected static function SingleDataGetter(int $id, string $sql) : array|bool
        {
            try {
                $values = array(':idTag' => $id);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new Exception("$id doesn't exist");
                }
                return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                return false;
            } finally {
                $pdoStatement = null;
            }
        }
    }