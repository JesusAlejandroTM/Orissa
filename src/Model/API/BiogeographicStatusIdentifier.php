<?php

    namespace App\Code\Model\API;

    class BiogeographicStatusIdentifier
    {
        public static function GetBiogeographicStatusName(string $bioId) : string|null
        {
            $list = TaxaAPI::GetBiogeographicStatusList();
            foreach ($list['biogeographicStatus'] as $status)
            {
                if ($bioId == $status['id']) return $status['name'];
            }
            return null;
        }

        public static function GetBiogeographicStatusDescription(string $bioId) : string|null
        {
            $list = TaxaAPI::GetBiogeographicStatusList();
            foreach ($list['biogeographicStatus'] as $status)
            {
                if ($bioId == $status['id']) return $status['definition'];
            }
            return null;
        }

    }