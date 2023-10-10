<?php

    namespace App\Web\Model\Repository;

    class AbstractRepository
    {
        /*public function select(string $identifier): AbstractDataObject|string
        {
            try {
                $sql = 'SELECT ' . $this->getSQLColumns() . ' FROM ' . $this->getNomTable() .
                    ' WHERE ' . $this->getPrimaryKeyColumn() . ' = :' . $this->getPrimaryKeyColumn() . 'Tag;';
                $values = array(':' . $this->getPrimaryKeyColumn() . 'Tag' => $identifier);
                $pdoStatement = DatabaseConnection::getPdo()->prepare($sql);
                $pdoStatement->execute($values);

                if ($pdoStatement->rowCount() < 1) {
                    throw new InvalidArgumentException("$identifier inexistant");
                }
                $data = $pdoStatement->fetch(PDO::FETCH_ASSOC);
                return $this->Construire($data);
            } catch (InvalidArgumentException $e) {
                return $e->getMessage();
            }
        }*/
    }