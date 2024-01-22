<?php

    namespace App\Code\Model\API;

    class BiogeographicStatusIdentifier
    {
        /**
         * Get the name of a biogeographic status from its id
         * @param string $bioId the id of the biogeographic status
         * @return string|null the name of the biogeographic status, null if not found
         */
        public static function GetBiogeographicStatusName(string $bioId) : string|null
        {
            $list = TaxaAPI::GetBiogeographicStatusList();
            foreach ($list['biogeographicStatus'] as $status)
            {
                if ($bioId == $status['id']) return $status['name'];
            }
            return null;
        }

        /**
         * Get the description of a biogeographic status from its id
         * @param string $bioId
         * @return string|null
         */
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