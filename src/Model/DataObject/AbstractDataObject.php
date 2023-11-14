<?php

    namespace App\Code\Model\DataObject;

    abstract class AbstractDataObject
    {
        public abstract function formatTableau(): array;
        public abstract function getPrimaryKeyValue() : int;
    }