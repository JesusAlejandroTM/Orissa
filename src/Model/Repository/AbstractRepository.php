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

        // Get SQL Columns of corresponding repository, set tagmode to true if you want the tag version for inputs
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

        // Get SQL Columns of corresponding repository without primaryKey,
        // set tagmode to true if you want the tag version for inputs
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

        private function GetSQLTags() : string
        {
            $arrayColonnes = $this->GetColumnsNames();
            $setColonnes = '';
            foreach ($arrayColonnes as $colonne) {
                $setColonnes .= ':' . $colonne . 'Tag, ';
            }
            return rtrim($setColonnes, ', ');
        }

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
         * @return AbstractDataObject[]
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

        public function Select(string $identifier): AbstractDataObject|string
        {
            try {
                $sql = 'SELECT ' . $this->GetSQLColumns() . ' FROM ' . $this->GetTableName() .
                    ' WHERE ' . $this->GetPrimaryKeyColumn() . ' = :' . $this->GetPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->GetPrimaryKeyColumn() . 'Tag' => $identifier);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$identifier inexistant");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Build($data);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }

        public function Delete(string $identifier): bool|string
        {
            try {
                $sql = 'DELETE FROM ' . $this->GetTableName() .
                    ' WHERE ' . $this->GetPrimaryKeyColumn() . ' = :' . $this->GetPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->GetPrimaryKeyColumn() . 'Tag' => $identifier);

                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);
                if ($pdoStatement->rowCount() == 0) {
                    throw new InvalidArgumentException("$identifier inexistant");
                }
                return true;
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }

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